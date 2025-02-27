<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TherapistDtr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
   
    
    public function index(Request $request)
    {
        $therapistName = auth()->user()->first_name; // Get the authenticated therapist's name
        $search = $request->input('search');
    
        // Query appointments for the specific therapist with optional search functionality
        $appointments = Appointment::where('therapist', $therapistName)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('services', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            })  
            ->paginate(10); // Paginate results (10 per page)
    
        $totalAppointments = Appointment::where('therapist', $therapistName)->count(); // Total appointments for therapist
    
        return view('therapist', compact('appointments', 'totalAppointments', 'search'));
    }

    public function dailyRecord(){
        return view('therapistComponents.dailyRecord');
    }

    public function therapistDtr(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_in' => 'required',
            'time_out' => 'required|after:time_in',
            'work_description' => 'nullable|string',
        ]);

        // Convert time_in and time_out to Carbon instances
        $timeIn = Carbon::parse($request->time_in);
        $timeOut = Carbon::parse($request->time_out);

        // Compute total hours
        $totalHours = $timeOut->diffInMinutes($timeIn) / 60; // Convert minutes to hours

        // Store the data in the database
        TherapistDtr::create([
            'user_id' => auth()->id(), // Ensure user is logged in
            'name' => auth()->user()->first_name ?? 'Unknown', // Get user's name if available
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'total_hours' => round($totalHours, 2), // Round to 2 decimal places
            'workdescriptions' => $request->work_description,
        ]);

        notify()->success('DTR recorded successfully!');
        return redirect()->back()->with('success', 'DTR recorded successfully!');
    }

    
    
}
