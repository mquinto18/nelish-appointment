@extends('layouts.therapist')

@section('title', 'Therapist')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">View Appointment</h1>
    </div>
    <div class="bg-white w-full p-3 rounded-md">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-[#FAFAD2] text-left">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Services</th>
                    <th class="border border-gray-300 px-4 py-2">Date</th>
                    <th class="border border-gray-300 px-4 py-2">Time</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($appointments->count() > 0)
                @foreach ($appointments as $appointment)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration + ($appointments->firstItem() - 1) }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $appointment->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $appointment->services }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-white font-bold 
                        {{ $appointment->status == 'pending' ? 'bg-orange-400' : 
                        ($appointment->status == 'Approved' ? 'bg-green-400' : 'bg-red-400') }}">
                        {{ $appointment->status }}
                    </td>
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

        <!-- Pagination -->
        @if ($appointments->count() > 0)
        <div class="mt-4">
            {{ $appointments->links() }}
        </div>
        @endif

    </div>
</div>

@endsection