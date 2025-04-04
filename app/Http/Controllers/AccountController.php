<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AccountController extends Controller
{
    // Update Account Details
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date',
            'mobile_number' => 'nullable|string|max:15',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'mobile_number' => $request->mobile_number,
        ]);
        notify()->success('Profile change successfully!');
        return redirect()->back()->with('success', 'Account details updated successfully.');
    }


    public function password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        notify()->success('Password updated successfully!');
        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    public function bookedAppointment()
    {
        // Retrieve only appointments of the logged-in user with pagination
        $appointments = Appointment::where('user_id', Auth::id())->paginate(10); // 10 items per page

        return view('appointment.bookedAppointment', compact('appointments'));
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        notify()->success('Appointment deleted successfully!');
        return redirect()->back()->with('success', 'Appointment deleted successfully!');
    }

    public function generateReceipt($id)
    {
        $appointment = Appointment::findOrFail($id);

        $services = json_decode($appointment->services, true); // Convert JSON to array
        $therapist = $appointment->therapist;
        $date = $appointment->date;
        $time = $appointment->time;
        $quantity = $appointment->quantity;
        $duration = $appointment->duration;
        $amount = $appointment->amount;
        $total = $amount * $quantity;

        $pdf = Pdf::loadView('appointment.receipt', compact('appointment', 'services', 'therapist', 'date', 'time', 'quantity', 'duration', 'amount', 'total'));

        return $pdf->stream('receipt.pdf'); // Display in browser
    }

    public function appointmentCanceled(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Approved,Cancelled,Completed',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        notify()->success('Appointment status updated successfully');
        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    public function reschedule($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointmentDate = $appointment->date;
        $duration = $appointment->duration;

        // Fetch booked slots for the selected date
        $bookedSlots = AppointmentSlot::where('date', $appointmentDate)
            ->pluck('booking_count', 'time')
            ->toArray();

        return view('appointment.appointmentSched', compact('appointment', 'bookedSlots', 'duration'));
    }

    public function rescheduleUpdate(Request $request, $id)
{
    $request->validate([
        'selected_time' => 'required|string',
        'selected_date' => 'required|date|after_or_equal:today',
    ]);

    // Find the appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Get the selected date and time
    $newDate = $request->input('selected_date');
    $newTime = $request->input('selected_time');

    // Convert the 12-hour time format to 24-hour format (if necessary)
    try {
        $newTime = Carbon::createFromFormat('g:i A', $newTime)->format('H:i:s');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid time format.');
    }

    // Check if the slot is available
    $slot = AppointmentSlot::where('date', $newDate)
        ->where('time', $newTime)
        ->first();

    // If the slot is fully booked, return an error
    if ($slot && $slot->booking_count >= 3) {
        return redirect()->back()->with('error', 'Selected time slot is fully booked. Please choose a different time.');
    }

    // Update the appointment with the new time and date
    $appointment->time = $newTime;
    $appointment->date = $newDate;
    $appointment->save();

    // Reduce the booking count for the old slot
    $oldSlot = AppointmentSlot::where('date', $appointment->date)
        ->where('time', $appointment->time)
        ->first();
    if ($oldSlot) {
        $oldSlot->booking_count -= 1;
        $oldSlot->save();
    }

    // Update the booking count for the new slot
    if ($slot) {
        $slot->booking_count += 1;
    } else {
        // Create a new slot if it doesn't exist
        $slot = new AppointmentSlot();
        $slot->user_id = $appointment->user_id;
        $slot->time = $newTime;
        $slot->therapist = $appointment->therapist;
        $slot->date = $newDate;
        $slot->booking_count = 1;
        $slot->save();
    }

    // Save the updated slot
    $slot->save();

    // Notify the user of success
    notify()->success('Appointment Updated successfully');
    return redirect()->route('booked.appointments')->with('success', 'Appointment rescheduled successfully!');
}
}
