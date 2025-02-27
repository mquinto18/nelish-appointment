@extends('layouts.user')

@section('title', 'Book Appointment')

@section('contents')

<style>
    body {
        background-color: #074F46;
    }

    .selected {
        background-color: #4CAF50 !important;
        /* Highlight selected */
        color: white !important;
    }

    .therapist-card {
        transition: background-color 0.3s ease;
    }

    .therapist-card.selected {
        background-color: #2F855A !important;
        /* Darker green for selection */
    }
</style>

<div>
    @include('appointment.navigation')

    <h1 class="text-white text-center">Select Time and Therapist</h1>

    <form action="{{ route('appointment.timeStore') }}" method="POST">
        @csrf
        <input type="hidden" name="selected_time" id="selected_time">
        <input type="hidden" name="selected_therapist" id="selected_therapist">

        <div class="flex gap-10 justify-center p-6">
            <!-- Time Selection -->
            <div class="bg-[#FFFFDB] p-4 rounded-md">
                <p class="font-bold text-[20px]">Select Time</p>
                <table class="w-[500px] border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Time</th>
                            <th class="border px-4 py-2">Choose</th>
                        </tr>
                    </thead>
                    <tbody id="time-slots">
                        @foreach ([
                        '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
                        '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM', '6:00 PM', '6:30 PM',
                        '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM', '9:00 PM', '9:30 PM'
                        ] as $time)
                        @php
                        $isBooked = in_array($time, $bookedTimes);
                        @endphp
                        <tr>
                            <td class="border px-4 py-2 text-center {{ $isBooked ? 'bg-[#F54C4C]' : 'cursor-pointer time-option' }}"
                                onclick="{{ $isBooked ? '' : "selectTime(this, '$time')" }}">
                                {{ $time }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 select-time-btn"
                                    onclick="{{ $isBooked ? '' : "selectTime(this, '$time')" }}" {{ $isBooked ? 'disabled' : '' }}>
                                    {{ $isBooked ? 'Booked' : 'Choose' }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Therapist Selection -->
            <div class="bg-[#FFFFDB] p-4 rounded-md">
                <p class="font-bold text-[20px]">Select Therapist</p>
                <div class="grid grid-cols-3 gap-5">
                    @foreach ($therapists as $therapist)
                    <div class="bg-[#074F46] py-5 px-3 flex flex-col rounded-md cursor-pointer therapist-card text-white text-center"
                        onclick="selectTherapist(this, '{{ $therapist->id }}', '{{ $therapist->first_name }}')">
                        <i class="fa-solid fa-circle-user text-[90px]"></i>
                        <p class="font-bold text-[15px] mt-3">{{ $therapist->first_name }}</p>
                        <p class="text-[13px]">Experience: {{ $therapist->experience }} years</p>
                        <p class="text-[13px]">Language: {{ $therapist->language }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Confirm Appointment</button>
        </div>
    </form>
</div>

<script>
    function selectTime(element, time) {
        document.getElementById('selected_time').value = time;

        // Remove previous selection
        document.querySelectorAll('.time-option, .select-time-btn').forEach(el => el.classList.remove('selected'));

        // Highlight selected
        element.classList.add('selected');
    }

    function selectTherapist(element, id, name) {
        document.getElementById('selected_therapist').value = id;

        // Remove previous selection
        document.querySelectorAll('.therapist-card').forEach(el => el.classList.remove('selected'));

        // Highlight selected
        element.classList.add('selected');
    }
</script>

@endsection