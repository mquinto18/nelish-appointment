@extends('layouts.admin')

@section('title', 'Appointment')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<!-- Bootstrap Modal -->

<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added modal-dialog-centered -->
        <div class="modal-content">
            <div class="modal-header bg-[#096156] text-white">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>

            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td id="modal-id"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="modal-name"></td>
                    </tr>
                    <tr>
                        <th>Services</th>
                        <td id="modal-services"></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td id="modal-date"></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td id="modal-time"></td>
                    </tr>
                    <tr>
                        <th>Therapist</th>
                        <td id="modal-therapist"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="modal-status"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Table -->
<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">View Appointment</h1>
        <div class="bg-white w-full p-3 rounded-md">

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-[#FAFAD2] text-left">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Services</th>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Time</th>
                        <th class="border border-gray-300 px-4 py-2">Therapist</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $appointment)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ is_array(json_decode($appointment->services, true)) ? implode(', ', json_decode($appointment->services, true)) : $appointment->services }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->therapist }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="{{ route('update.appointment.status', $appointment->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                    class="border p-1 rounded w-full 
    {{ $appointment->status == 'Pending' ? 'bg-orange-400' : ($appointment->status == 'Approved' ? 'bg-green-400' : 'bg-red-400') }} text-white">
                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $appointment->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $appointment->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <div class="flex justify-center items-center gap-3">
                                <form action="{{ route('appointments.edit', $appointment->id) }}" method="GET">
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>
                                <button type="button" class="text-green-500 hover:text-green-700 view-btn"
                                    data-bs-toggle="modal" data-bs-target="#appointmentModal"
                                    data-id="{{ $appointment->id }}"
                                    data-name="{{ $appointment->name }}"
                                    data-services="{{ is_array(json_decode($appointment->services, true)) ? implode(', ', json_decode($appointment->services, true)) : $appointment->services }}"
                                    data-date="{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}"
                                    data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}"
                                    data-therapist="{{ $appointment->therapist }}"
                                    data-status="{{ $appointment->status }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <form action="{{ route('appointment.delete', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".view-btn").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("modal-id").innerText = this.getAttribute("data-id");
                document.getElementById("modal-name").innerText = this.getAttribute("data-name");
                document.getElementById("modal-services").innerText = this.getAttribute("data-services");
                document.getElementById("modal-date").innerText = this.getAttribute("data-date");
                document.getElementById("modal-time").innerText = this.getAttribute("data-time");
                document.getElementById("modal-therapist").innerText = this.getAttribute("data-therapist");
                document.getElementById("modal-status").innerText = this.getAttribute("data-status");
            });
        });
    });
</script>

@endsection