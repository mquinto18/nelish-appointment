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
                'service_title' => 'required|json',
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
            $totalAmount = $validated['service_price'];

            // Prepare the booking details to store in the session
            $bookingData = [
                'user_id' => $user->id,
                'first_name' => $firstName, // Store only the first name
                'email' => $user->email,
                'services' => json_decode($validated['service_title'], true),
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


        session(['selected_date' => $bookingTime]);


        return redirect()->route('appointment.time')->with('success', 'Service details stored in session.');
    }
    public function appointmentTime()
{
    $bookingData = session('service_booking', []);
    $selectedDate = session('selected_date', now()->toDateString());

    // Retrieve duration from session or set a default value
    $duration = session('service_booking.duration', 60);

    // Retrieve all booked times with booking count
    $bookedTimes = AppointmentSlot::where('date', $selectedDate)
        ->pluck('booking_count', 'time') // Retrieve time and booking count
        ->mapWithKeys(function ($count, $time) {
            return [\Carbon\Carbon::createFromFormat('H:i:s', $time)->format('g:i A') => $count];
        })
        ->toArray();

    // ✅ Get therapists who are booked per time slot
    $bookedTherapists = AppointmentSlot::where('date', $selectedDate)
        ->pluck('user_id', 'time') // Retrieve therapist IDs per time slot
        ->mapWithKeys(function ($therapistId, $time) {
            return [\Carbon\Carbon::createFromFormat('H:i:s', $time)->format('g:i A') => $therapistId];
        })
        ->toArray();

    $therapists = User::where('role', 'manager')->get();

    return view('appointment.time_appointment', compact(
        'bookingData', 'therapists', 'bookedTimes', 'bookedTherapists', 'selectedDate', 'duration'
    ));
}




    public function storeTime(Request $request)
    {

        $validated = $request->validate([
            'selected_time' => 'required',
            'selected_therapist' => 'required|string', // JSON string
        ]);

        // Decode the JSON string into an array
        $selectedTherapists = json_decode($validated['selected_therapist'], true);

        // Store it correctly in the session
        $bookingTime = [
            'time' => $validated['selected_time'],
            'therapist_name' => $selectedTherapists, // Store as an array
        ];

        session(['selected_time' => $bookingTime]);

        return redirect()->route('appointment.appointment_confirm')->with('success', 'Time and therapist selection stored in session.');
    }



    public function appointmentConfirm()
    {
        $serviceBooking = session('service_booking', []);
        $selectedDate = session('selected_date', []);
        $selectedTime = session('selected_time', []);

        $bookingData = array_merge($serviceBooking, $selectedDate, $selectedTime);

        // Check if therapist exists in session
        if (isset($bookingData['therapist_name'])) {
            $therapists = is_array($bookingData['therapist_name']) ? $bookingData['therapist_name'] : json_decode($bookingData['therapist_name'], true);
            $bookingData['therapist_name'] = is_array($therapists) ? implode(', ', $therapists) : 'Unknown Therapist';
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

        $user = Auth::user();
        $validated['time'] = Carbon::parse($validated['time'])->format('H:i:s');
        $validated['services'] = json_encode($validated['services']);
        $validated['user_id'] = $user->id ?? null;
        $validated['name'] = $user->first_name ?? 'Guest';
        $validated['email'] = $user->email ?? null;

        // **Check existing slot record**
        $slot = AppointmentSlot::where('time', $validated['time'])
            ->where('therapist', $validated['therapist'])
            ->where('date', $validated['date'])
            ->first();

        if ($slot && $slot->booking_count >= 3) {
            return redirect()->back()->with('error', 'The selected time slot is fully booked.');
        }

        // **Create Appointment**
        $appointment = Appointment::create($validated);

        // **Reserve Slot**
        if ($slot) {
            // If the slot already exists, increment booking_count
            $slot->increment('booking_count');
        } else {
            // Otherwise, create a new slot with booking_count = 1
            AppointmentSlot::create([
                'user_id' => $validated['user_id'],
                'time' => $validated['time'],
                'therapist' => $validated['therapist'],
                'date' => $validated['date'],
                'booking_count' => 1, // Set initial count
            ]);
        }

        notify()->success('Appointment submitted successfully!');
        return redirect()->route('home')->with('success', 'Appointment booked successfully!');
    }



    public function accountSettings()
    {
        return view('auth.settings');
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date',
            'mobile_number' => 'nullable|string|max:15',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'mobile_number' => $request->mobile_number,
        ]);

        return redirect()->back()->with('success', 'Account details updated successfully.');
    }
}
