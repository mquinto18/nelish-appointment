@extends('layouts.admin')

@section('title', 'Appointment')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>
<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Therapist Schedule</h1>
    </div>
    <div class="bg-white p-4 rounded-lg">
        @foreach($managers as $manager)
        <div x-data="{ showTable: false }" class="bg-[#074E45] text-white py-3 px-4 rounded-lg w-full mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fa-solid fa-circle-user text-[30px]"></i>
                </div>
                <div class="text-[15px]">
                    {{ $manager->first_name }}
                </div>
                <button
                    @click="showTable = !showTable"
                    class="toggleButton bg-white py-1 px-4 text-black rounded-md">
                    View
                </button>
            </div>

            <!-- Appointment Table (Hidden by Default) -->
            <div x-show="showTable" class="adminDetails leading-3 mt-6 bg-white text-black p-4 shadow-lg rounded-lg">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Manager</th>
                            <th class="border border-gray-300 px-4 py-2">Date</th>
                            <th class="border border-gray-300 px-4 py-2">Time</th>
                            <th class="border border-gray-300 px-4 py-2">Type of Spa</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $managerAppointments = $appointments->where('therapist', $manager->first_name);
                        @endphp

                        @if($managerAppointments->isNotEmpty())
                        @foreach($managerAppointments as $appointment)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $appointment->therapist }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $appointment->date }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ date('h:i A', strtotime($appointment->time)) }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ implode(', ', json_decode($appointment->services, true)) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($appointment->status) }}</td>
                            <td class="border border-gray-300 px-4 py-2">₱{{ number_format($appointment->amount, 2) }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                No appointments found.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- View DTR Button (Only Visible When Table is Open) -->
            <div class="flex justify-end">
                <a x-show="showTable" href="{{ route('dtr.view', ['therapist' => $manager->first_name]) }}" class="bg-white py-1 px-4 text-black rounded-md no-underline mt-3">View DTR</a>
            </div>
        </div>
        @endforeach

    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


@endsection