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
        <h1 class="text-[30px] text-white">Therapist daily time record</h1>
    </div>
    <div class="bg-white p-4 rounded-lg">
        <div class="flex justify-between gap-2 mb-4">
            <div class="text-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">
                    {{ $startOfWeek->format('F j') }} - {{ $endOfWeek->format('j, Y') }}
                </h2>
            </div>
            <!-- Previous Week Button -->
            <div class="flex justify-center items-center gap-3">
                <a href="{{ route('dtr.view', ['therapist' => $therapist, 'weekOffset' => $weekOffset - 1]) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded no-underline">
                    Previous Week
                </a>

                <!-- Next Week Button -->
                <a href="{{ route('dtr.view', ['therapist' => $therapist, 'weekOffset' => $weekOffset + 1]) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded no-underline">
                    Next Week
                </a>
            </div>
        </div>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Week 1</th>
                    <th class="border border-gray-300 px-4 py-2">Date</th>
                    <th class="border border-gray-300 px-4 py-2">Employee Name</th>
                    <th class="border border-gray-300 px-4 py-2">Time In</th>
                    <th class="border border-gray-300 px-4 py-2">Time Out</th>
                    <th class="border border-gray-300 px-4 py-2">Work Descriptions</th>
                    <th class="border border-gray-300 px-4 py-2">Total Hours</th>
                </tr>
            </thead>
            <tbody>
                @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                @endphp
                @foreach($days as $day)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 font-bold">{{ $day }}</td>

                    @php
                    $record = $dtrRecords->filter(function ($dtr) use ($day) {
                    return \Carbon\Carbon::parse($dtr->date)->format('l') === $day;
                    })->first();
                    @endphp

                    @if($record)
                    <td class="border border-gray-300 px-4 py-2">
                        {{ \Carbon\Carbon::parse($record->date)->format('F j, Y') }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ $record->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ $record->workdescriptions }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ abs($record->total_hours) }}</td>
                    @else
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="6">No data</td>
                    @endif
                </tr>
                @endforeach
            </tbody>

        </table>


    </div>
</div>

@endsection