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
        <input type="hidden" id="selected_therapist" name="selected_therapist" value="[]">


        <div class="flex justify-center items-center">
            <div class="flex flex-col gap-10 justify-center p-6">
                <!-- Time Selection -->
                <div class="bg-[#FFFFDB] p-4 rounded-md">
                    <p class="font-bold text-[20px]">Select Time</p>
                    <table class="w-[500px] border-collapse">
                        <tbody id="time-slots">
                            @php
                            $timeSlots = ($duration == 60) ?
                            ['1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM', '8:00 PM', '9:00 PM', '10:00 PM', '11:00 PM'] :
                            ['1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
                            '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM', '6:00 PM', '6:30 PM',
                            '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM', '9:00 PM', '9:30 PM', '10:00 PM', '10:30 PM', '11:00 PM'];

                            $maxSlots = 3; // Maximum slots per time
                            @endphp

                            @foreach ($timeSlots as $index => $time)
                            @php
                            $bookingCount = isset($bookedTimes[$time]) ? $bookedTimes[$time] : 0;
                            $availableSlots = max(0, $maxSlots - $bookingCount);
                            $isFullyBooked = $availableSlots <= 0;
                                @endphp

                                {{-- Open a new row every 3 items --}}
                                @if ($index % 3==0)
                                <tr>
                                @endif

                                <td class="border px-4 py-3 text-center {{ $isFullyBooked ? 'bg-[#F54C4C] text-white' : 'cursor-pointer time-option' }}"
                                    onclick="{{ $isFullyBooked ? '' : "selectTime(this, '$time')" }}">
                                    <div>{{ $time }}</div>
                                    <div class="text-sm text-gray-600">
                                        @if (!$isFullyBooked)
                                        ({{ $availableSlots }} {{ $availableSlots == 1 ? 'slot' : 'slots' }} available)
                                        @else
                                        (Fully booked)
                                        @endif
                                    </div>
                                </td>


                                {{-- Close row every 3 items or at the last item --}}
                                @if ($index % 3 == 2 || $index == count($timeSlots) - 1)
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
                    </table>

                </div>

                <!-- Therapist Selection -->
                <div class="bg-[#FFFFDB] p-4 rounded-md">
                    <p class="font-bold text-[20px]">Select Therapist</p>
                    <table class="w-full border-collapse border border-gray-300 mt-3">
                        @foreach ($therapists as $therapist)
                        @php
                        $isBooked = isset($selected_time, $bookedTherapists[$selected_time]) &&
                        in_array($therapist->first_name, $bookedTherapists[$selected_time]);
                        @endphp

                        <td class="border border-gray-300 px-6 py-4 text-center cursor-pointer 
        {{ $isBooked ? 'bg-red-400 text-white cursor-not-allowed' : '' }} "
                            onclick="{{ !$isBooked ? "selectTherapist(this, '$therapist->id', '$therapist->first_name')" : '' }}">
                            {{ $therapist->first_name }}
                            @if ($isBooked)
                            <br><span class="text-sm">(Fully booked)</span>
                            @endif
                        </td>
                        @endforeach


                    </table>
                </div>

            </div>

            <div class="bg-[#FFFFDB] my-20 mx-10 w-[500px] rounded-md flex flex-col justify-between min-h-[400px]">
                <div class="text-black border-b-2 py-6 border-black">
                    <h1 class="text-center text-[30px]">Booking Summary</h1>
                </div>

                @if(!empty($bookingData))
                <div class="p-4 my-2">
                    <p class="font-medium">Selected Services:</p>
                    <ul class="list-none pl-2">
                        @foreach($bookingData['services'] as $service)
                        <li>• {{ $service }}</li>
                        @endforeach
                    </ul>
                    <p>Duration: {{ $bookingData['duration'] }} Minutes</p>
                    <p>Quantity: {{ $bookingData['quantity'] }} Person(s)</p>
                    <p>Total Amount: {{ number_format($bookingData['amount'], 2) }} Pesos</p>
                </div>
                @else
                <p>No booking data available.</p>
                @endif


                <input type="hidden" name="selected_date" id="selected_date">
                <div class="p-4 border-t border-black text-center">
                    <button type="submit" class="bg-yellow-400 px-6 py-2 rounded-md">
                        Continue
                    </button>
                </div>
            </div>
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
        let selectedInput = document.getElementById('selected_therapist');
        let selectedTherapists = selectedInput.value ? JSON.parse(selectedInput.value) : [];

        // If the same therapist is clicked again, deselect them
        if (selectedTherapists.includes(name)) {
            selectedTherapists = []; // Clear selection
            element.classList.remove('selected');
        } else {
            // Deselect any previously selected therapist
            document.querySelectorAll('.therapist').forEach(el => el.classList.remove('selected'));

            // Select the new therapist
            selectedTherapists = [name];
            element.classList.add('selected');
        }

        // Update the input value
        selectedInput.value = JSON.stringify(selectedTherapists);

        console.log("Selected Therapist:", selectedInput.value);
    }
</script>

@endsection