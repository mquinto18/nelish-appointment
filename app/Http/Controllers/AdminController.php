<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Therapist;
use App\Models\TherapistDtr;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        // Fetch approved admins from the database
        $admins = User::where('role', 'admin')->get();
    
        // Fetch pending admins from the session
        $pendingAdmins = session()->get('pending_admins', []);
    
        return view('admin', compact('admins', 'pendingAdmins'));
    }

    public function approveAdmin($email) {
        $pendingAdmins = session()->get('pending_admins', []);
    
        foreach ($pendingAdmins as $index => $admin) {
            if ($admin['email'] === $email) {
                // Save admin to the database
                User::create([
                    'first_name' => $admin['first_name'],
                    'last_name' => $admin['last_name'],
                    'email' => $admin['email'],
                    'birth_date' => $admin['birth_date'],
                    'mobile_number' => $admin['mobile_number'],
                    'password' => Hash::make($admin['password']), // Ensure password is hashed
                    'role' => 'admin',
                ]);
    
                // Remove from pending session
                unset($pendingAdmins[$index]);
                session()->put('pending_admins', array_values($pendingAdmins));
    
                return redirect()->route('admin.home')->with('success', 'Admin approved successfully.');
            }
        }
    
        return redirect()->route('admin.home')->with('error', 'Admin not found.');
    }

    public function rejectAdmin($email) {
        // Retrieve pending admins from session
        $pendingAdmins = session()->get('pending_admins', []);
    
        // Remove the rejected admin
        $updatedAdmins = array_filter($pendingAdmins, function ($admin) use ($email) {
            return $admin['email'] !== $email;
        });
    
        // Update the session
        session()->put('pending_admins', array_values($updatedAdmins));
    
        return redirect()->back()->with('error', 'Admin request rejected.');
    }

    public function clientTherapist(){
        $clients = User::where('role', 'user')->get();
        $therapists = Therapist::all();
       
        return view('adminComponents.clientTherapistData', compact('clients', 'therapists'));
    }

    public function viewAppointment() {
        $appointments = Appointment::paginate(7); // Limit to 2 rows per page
        return view('adminComponents.listAppointment', compact('appointments'));
    }
    
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        
        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function appointmentEdit($id) {
        $appointment = Appointment::findOrFail($id); // Fetch appointment by ID
        return view('adminComponents.appointmentEdit', compact('appointment'));
    }

    public function appointmentUpdate(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'therapist' => 'required|string|max:255',
            'services' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'amount' => 'required|numeric',
            'quantity' => 'required|integer',
            'duration' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        notify()->success('Appointment updated successfully');
        return redirect()->route('appointments.edit', $id)->with('success', 'Appointment updated successfully!');
    }

    public function destroy($id)
{
    $appointment = Appointment::find($id);

    if (!$appointment) {
        return redirect()->back()->with('error', 'Appointment not found.');
    }

    $appointment->delete();
    notify()->success('Appointment deleted successfully');
    return redirect()->back()->with('success', 'Appointment deleted successfully.');
}

public function therapistSched()
{
    // Fetch managers
    $managers = User::where('role', 'manager')->get();

    // Fetch appointments grouped by therapist
    $appointments = Appointment::whereIn('therapist', $managers->pluck('first_name'))->get();

    return view('adminComponents.therapistSched', compact('managers', 'appointments'));
}
public function dtrView($therapist, $weekOffset = 0)
{
    $weekOffset = (int) $weekOffset; // Ensure it's an integer

    $startOfWeek = \Carbon\Carbon::now()->startOfWeek()->addWeeks($weekOffset);
    $endOfWeek = $startOfWeek->copy()->endOfWeek();

    // Fetch DTR records for the selected week
    $dtrRecords = TherapistDtr::where('name', $therapist)
        ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
        ->get();

    // Pass startOfWeek and endOfWeek to the view
    return view('adminComponents.adminDtrView', compact('dtrRecords', 'therapist', 'weekOffset', 'startOfWeek', 'endOfWeek'));
}


    
}
