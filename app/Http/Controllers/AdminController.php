<?php

namespace App\Http\Controllers;

use App\Exports\TransactionHistoryExport;
use App\Models\Appointment;
use App\Models\Therapist;
use App\Models\TherapistDtr;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $totalClients = User::where('role', 'user')->count();
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $todaysAppointments = Appointment::whereDate('date', today())
            ->where('status', 'approved')
            ->take(2)
            ->get();

        $appointmentRequests = Appointment::where('status', 'pending')->take(2)->get();

        return view('admin', compact(
            'totalClients',
            'totalAppointments',
            'completedAppointments',
            'todaysAppointments',
            'appointmentRequests'
        ));
    }


    public function approveAdmin($email)
    {
        $pendingAdmins = session()->get('pending_admins', []);

        foreach ($pendingAdmins as $index => $admin) {
            if ($admin['email'] === $email) {

                User::create([
                    'first_name' => $admin['first_name'],
                    'last_name' => $admin['last_name'],
                    'email' => $admin['email'],
                    'birth_date' => $admin['birth_date'],
                    'mobile_number' => $admin['mobile_number'],
                    'password' => Hash::make($admin['password']),
                    'role' => 'admin',
                ]);


                unset($pendingAdmins[$index]);
                session()->put('pending_admins', array_values($pendingAdmins));

                return redirect()->route('admin.home')->with('success', 'Admin approved successfully.');
            }
        }

        return redirect()->route('admin.home')->with('error', 'Admin not found.');
    }

    public function rejectAdmin($email)
    {

        $pendingAdmins = session()->get('pending_admins', []);


        $updatedAdmins = array_filter($pendingAdmins, function ($admin) use ($email) {
            return $admin['email'] !== $email;
        });


        session()->put('pending_admins', array_values($updatedAdmins));

        return redirect()->back()->with('error', 'Admin request rejected.');
    }

    public function clientTherapist()
    {
        $clients = User::where('role', 'user')->get();
        $therapists = User::where('role', 'manager')->get();

        return view('adminComponents.clientTherapistData', compact('clients', 'therapists'));
    }

    public function viewAppointment()
    {
        $appointments = Appointment::paginate(7);
        $managers = User::where('role', 'manager')->get(); // Fetch all users with the manager role

        return view('adminComponents.listAppointment', compact('appointments', 'managers'));
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Completed'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();


        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function appointmentEdit($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('adminComponents.appointmentEdit', compact('appointment'));
    }

    public function appointmentUpdate(Request $request, $id)
{
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
        'payment_status' => 'required|in:paid,not paid', // Ensure valid payment status
    ]);

    $appointment = Appointment::findOrFail($id);
    
    // Update only allowed fields
    $appointment->update([
        'name' => $request->name,
        'email' => $request->email,
        'therapist' => $request->therapist,
        'services' => $request->services,
        'date' => $request->date,
        'time' => $request->time,
        'amount' => $request->amount,
        'quantity' => $request->quantity,
        'duration' => $request->duration,
        'payment_status' => $request->payment_status,
    ]);

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

    public function systemuserdelete($id)
    {
        $user = User::find($id); // Find user instead of appointment

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->delete(); // Delete user

        notify()->success('User deleted successfully');
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function therapistSched()
    {
        $managers = User::where('role', 'manager')->get();
        $appointments = Appointment::whereIn('therapist', $managers->pluck('first_name'))->get();

        return view('adminComponents.therapistSched', compact('managers', 'appointments'));
    }


    public function dtrView(Request $request, $therapist, $weekOffset = 0)
{
    $weekOffset = (int) $weekOffset;
    $month = $request->query('month');

    // Convert month name to a numeric value
    $selectedMonth = $month ? Carbon::parse("1 $month")->month : null;
    $currentYear = Carbon::now()->year;

    if ($selectedMonth) {
        // If a month is selected, set startOfWeek to first day of the selected month
        $startOfWeek = Carbon::createFromDate($currentYear, $selectedMonth, 1)->startOfWeek();
    } else {
        // Default: Use the current week with offset
        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
    }

    $endOfWeek = $startOfWeek->copy()->endOfWeek();

    // Filter DTR records by therapist and selected month
    $dtrRecords = TherapistDtr::where('name', $therapist)
        ->when($selectedMonth, function ($query) use ($selectedMonth) {
            return $query->whereMonth('date', $selectedMonth);
        })
        ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
        ->get();

    return view('adminComponents.adminDtrView', compact('dtrRecords', 'therapist', 'weekOffset', 'startOfWeek', 'endOfWeek', 'selectedMonth'));
}


    public function systemuser(Request $request)
    {
        $search = $request->input('search');


        $users = User::when($search, function ($query, $search) {
            return $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('adminComponents.systemUser', compact('users', 'search'));
    }

    public function saveUser(Request $request)

    {    // Validate input data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'birthday' => 'required|date',
            'mobile_number' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin,manager',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create and save user
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birthday,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
            'role' => $request->role,
        ]);

        notify()->success('Employee added successfully!');
        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function viewDTR()
    {
        $managers = User::where('role', 'manager')->get();


        $appointments = Appointment::whereIn('therapist', $managers->pluck('first_name'))->get();

        return view('adminComponents.viewDtr', compact('managers', 'appointments'));
    }

    public function manageaccount()
    {
        // Fetch only users where role is 'admin'
        $admins = User::where('role', 'admin')->get();

        return view('adminComponents.manageAccount', compact('admins'));
    }

    public function systemuserEdit($id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Return the view with the user data
        return view('adminComponents.systemUserEdit', compact('user'));
    }
    public function systemUserUpdate(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'mobile_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's information
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->mobile_number = $request->input('mobile_number');
        $user->gender = $request->input('gender');
        $user->birth_date = $request->input('birth_date');

        // Save the changes
        $user->save();

        notify()->success('Updated successfully!');
        return redirect()->back()->with('success', 'User updated successfully!');
    }
    public function updateTherapist(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->therapist = $request->therapist;
        $appointment->save();
        notify()->success('Updated successfully!');
        return redirect()->back()->with('success', 'Therapist updated successfully!');
    }

    public function transactionHistory(Request $request)
    {
        $query = Appointment::where('status', 'Completed');

        if ($request->has('year') && $request->year) {
            $query->whereYear('date', $request->year);
        }

        if ($request->has('month') && $request->month) {
            $query->whereMonth('date', $request->month);
        }

        $appointments = $query->get();

        return view('adminComponents.transactionHistory', compact('appointments'));
    }

    public function downloadReport(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $fileName = 'Transaction_History_' . ($year ?? 'All') . '_' . ($month ? date('F', mktime(0, 0, 0, $month, 1)) : 'All') . '.xlsx';

        return Excel::download(new TransactionHistoryExport($year, $month), $fileName);
    }

    public function manageadmin(){
        return view('adminComponents.manageadmin');
    }

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
}
