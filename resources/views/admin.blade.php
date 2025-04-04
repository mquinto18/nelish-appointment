@extends('layouts.admin')

@section('title', 'Admin')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="">
    <h1 class="text-[30px] text-white">Admin Dashboard</h1>

    <div class="flex gap-4 py-3">
        <!-- Total Clients -->
        <div class="bg-white w-full p-4 rounded-md flex items-center gap-3 shadow-md">
            <i class="fas fa-user text-4xl"></i>
            <div>
                <h2 class="text-xl font-bold">{{ $totalClients }}</h2>
                <p class="text-gray-600">Total client register</p>
            </div>
        </div>

        <!-- Total Appointments -->
        <div class="bg-white w-full p-4 rounded-md flex items-center gap-3 shadow-md border-2">
            <i class="fas fa-calendar-alt text-4xl"></i>

            <div>
                <h2 class="text-xl font-bold">{{ $totalAppointments }}</h2>
                <p class="text-gray-600">Total Appointments</p>
            </div>
        </div>

        <!-- Completed Appointments -->
        <div class="bg-white w-full p-4 rounded-md flex items-center gap-3 shadow-md">
            <i class="fas fa-calendar text-4xl"></i>
            <div>
                <h2 class="text-xl font-bold">{{ $completedAppointments }}</h2>
                <p class="text-gray-600">Total Appointments Completed</p>
            </div>
        </div>
    </div>

    <div>
        <h1 class="text-[25px] text-white">Today's Appointment</h1>
        <div>
            <table class="w-full border-collapse border bg-white">
                <thead class="bg-[#FAFAD2] text-left">
                    <tr>
                        <th class="border bg-white px-4 py-2">ID</th>
                        <th class="border bg-white px-4 py-2">Name</th>
                        <th class="border bg-white px-4 py-2">Services</th>
                        <th class="border bg-white px-4 py-2">Date</th>
                        <th class="border bg-white px-4 py-2">Time</th>
                        <th class="border bg-white px-4 py-2">Therapist</th>
                        <th class="border bg-white px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todaysAppointments as $appointment)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ implode(', ', json_decode($appointment->services, true)) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->date }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->time }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->therapist }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ ucfirst($appointment->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8" class="text-center border-t bg-white py-1">
                            <a href="{{ route('viewAppointment') }}" class="text-blue-500 text-sm font-bold no-underline hover:underline">
                                View all
                            </a>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

    <div class="mt-5">
        <h1 class="text-[25px] text-white">Appointment Request</h1>
        <div>
            <table class="w-full border-collapse border bg-white">
                <thead class="bg-[#FAFAD2] text-left">
                    <tr>
                        <th class="border bg-white px-4 py-2">ID</th>
                        <th class="border bg-white px-4 py-2">Name</th>
                        <th class="border bg-white px-4 py-2">Services</th>
                        <th class="border bg-white px-4 py-2">Date</th>
                        <th class="border bg-white px-4 py-2">Time</th>
                        <th class="border bg-white px-4 py-2">Therapist</th>
                        <th class="border bg-white px-4 py-2">Status</th>
                        <th class="border bg-white px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointmentRequests->take(2) as $appointment)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ implode(', ', json_decode($appointment->services, true)) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->date }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->time }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->therapist }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ ucfirst($appointment->status) }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="{{ route('update.appointment.status', $appointment->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                    class="border p-1 rounded w-full {{ $appointment->status == 'Pending' ? 'bg-orange-400' : ($appointment->status == 'Approved' ? 'bg-green-400' : ($appointment->status == 'Completed' ? 'bg-blue-400' : 'bg-red-400')) }}
 text-white">
                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $appointment->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $appointment->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8" class="text-center border-t bg-white py-1">
                            <a href="{{ route('viewAppointment') }}" class="text-blue-500 text-sm font-bold no-underline hover:underline">
                                View all
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".toggleButton").forEach((button, index) => {
        button.addEventListener("click", function() {
            document.querySelectorAll(".adminDetails")[index].classList.toggle("hidden");
        });
    });
</script>

@endsection