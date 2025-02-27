<?php

namespace App\Http\Controllers;


use Carbon\Carbon; // Make sure to import Carbon
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\User;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function spa_appointment()
    {
        return view('appointment.services_appointment');
    }

    public function storeServices(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'service_title' => 'required|string',
                'service_price' => 'required|numeric',
                'duration' => 'required|integer',
                'people_count' => 'required|integer|min:1',
            ]);

            // Get the logged-in user
            $user = auth()->user();
            if (!$user) {
                return back()->with('error', 'You must be logged in to book a service.');
            }

            // Extract the first name from the full name
            $firstName = explode(' ', trim($user->first_name))[0];

            // Calculate total amount based on quantity
            $totalAmount = $validated['service_price'] * $validated['people_count'];

            // Prepare the booking details to store in the session
            $bookingData = [
                'user_id' => $user->id,
                'first_name' => $firstName, // Store only the first name
                'email' => $user->email,
                'services' => [$validated['service_title']],
                'amount' => $totalAmount,
                'duration' => $validated['duration'],
                'quantity' => $validated['people_count'],
            ];

            

            // Store the booking details in the session
            session(['service_booking' => $bookingData]);

            return redirect()->route('appointment.date')->with('success', 'Service details stored in session.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to store the service details. Please try again.');
        }
    }


    public function appointmentDate()
    {
        $bookingData = session('service_booking', []);
        return view('appointment.date_appointment', compact('bookingData'));
    }

    public function storeDate(Request $request)
    {
        $validated = $request->validate([
            'selected_date' => 'required|date',
        ]);

        $bookingTime = [
            'date' => $validated['selected_date'],
        ];

        // Store selected date in session
        session(['selected_date' => $bookingTime]);

        // Dump and die to check the session data
        return redirect()->route('appointment.time')->with('success', 'Service details stored in session.');
    }
    public function appointmentTime()
{
    $bookingData = session('service_booking', []);
    $selectedDate = session('selected_date', now()->toDateString()); // Ensure the date is set

    // Fetch booked slots for the selected date and convert to 12-hour format
    $bookedTimes = AppointmentSlot::where('date', $selectedDate)
        ->pluck('time')
        ->map(function ($time) {
            return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('g:i A'); // Convert to 12-hour format
        })
        ->toArray();

    $therapists = User::where('role', 'manager')->get(); // Fetch only managers

    return view('appointment.time_appointment', compact('bookingData', 'therapists', 'bookedTimes', 'selectedDate'));
}
    public function storeTime(Request $request)
    {
        $validated = $request->validate([
            'selected_time' => 'required',
            'selected_therapist' => 'required|string', // Ensure therapist name is provided
        ]);

        $bookingTime = [
            'time' => $validated['selected_time'],
            'therapist' => $validated['selected_therapist'], // Store only therapist name
        ];

        // Store selected time and therapist in session
        session(['selected_time' => $bookingTime]);

        return redirect()->route('appointment.appointment_confirm')->with('success', 'Time and therapist selection stored in session.');
    }


    public function appointmentConfirm()
    {
        // Fetch session data separately
        $serviceBooking = session('service_booking', []);
        $selectedDate = session('selected_date', []);
        $selectedTime = session('selected_time', []);

        // Combine all session data into one array
        $bookingData = array_merge($serviceBooking, $selectedDate, $selectedTime);

        // Check if therapist ID exists in session
        if (isset($bookingData['therapist'])) {
            $therapist = User::find($bookingData['therapist']); // Fetch therapist by ID
            $bookingData['therapist_name'] = $therapist ? $therapist->first_name : 'Unknown Therapist'; // Handle null case
        } else {
            $bookingData['therapist_name'] = 'Unknown Therapist';
        }

        return view('appointment.confirm_appointment', compact('bookingData'));
    }

  

    
    public function confirmStore(Request $request)
{
    $validated = $request->validate([
        'services' => 'required|array',
        'duration' => 'required|integer',
        'quantity' => 'required|integer',
        'date' => 'required|date',
        'time' => 'required',
        'therapist' => 'required|string',
        'amount' => 'required|numeric',
    ]);

    // Get the logged-in user
    $user = Auth::user();

    // Convert time to 24-hour format (HH:MM:SS)
    $validated['time'] = Carbon::parse($validated['time'])->format('H:i:s');

    // Convert services array to JSON before storing
    $validated['services'] = json_encode($validated['services']);

    // Add user details
    $validated['user_id'] = $user->id ?? null; // Store user ID (nullable for guests)
    $validated['name'] = $user->first_name ?? 'Guest'; // Store user name (default to 'Guest' if not logged in)
    $validated['email'] = $user->email ?? null;
    // Check if the slot is available
    $slotExists = AppointmentSlot::where('time', $validated['time'])
        ->where('therapist', $validated['therapist'])
        ->where('date', $validated['date'])
        ->exists();

    if ($slotExists) {
        return redirect()->back()->with('error', 'The selected time slot is already booked.');
    }

    // Save appointment to database
    $appointment = Appointment::create($validated);

    // Insert the slot into appointment_slots table
    AppointmentSlot::create([
        'user_id' => $validated['user_id'],
        'time' => $validated['time'],
        'therapist' => $validated['therapist'],
        'date' => $validated['date'],
    ]);
    notify()->success('Appointment submitted successfully!');
    return redirect()->route('home')->with('success', 'Appointment booked successfully!');
}



}
