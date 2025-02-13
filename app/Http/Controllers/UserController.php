<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

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

            // Get the logged-in user's name and user ID
            $user = auth()->user();
            if (!$user) {
                return back()->with('error', 'You must be logged in to book a service.');
            }

            // Calculate total amount based on quantity
            $totalAmount = $validated['service_price'] * $validated['people_count'];

            // Prepare the booking details to store in the session
            $bookingData = [
                'user_id' => $user->id,
                'name' => $user->name,
                'services' => [$validated['service_title']], // Store as array
                'amount' => $totalAmount, // Updated: total price
                'duration' => $validated['duration'],
                'quantity' => $validated['people_count'],
            ];

            // Store the booking details in the session
            session(['service_booking' => $bookingData]);




            // Redirect to the next page (or back) with success message
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

    public function storeDate(Request $request){
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
    public function appointmentTime(){
        $bookingData = session('service_booking', 'selected_date', []);
        return view('appointment.time_appointment', compact('bookingData'));
    }
}
