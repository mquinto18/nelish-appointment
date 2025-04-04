@extends('layouts.user')

@section('title', 'Booked Appointment')

@section('contents')

<style>
    body {
        background-color: #074F46;
    }

    .selected-time {
        background-color: #4CAF50 !important;
        color: white !important;
        font-weight: bold;
        border-radius: 5px;
    }

    #calendar-container {
        background: #F5F5DC;
        padding: 20px;
        border-radius: 10px;
        width: 600px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    }

    #calendar {
        background: transparent;
        border: none;
    }

    .fc-day-today {
        background: transparent !important;
        text-decoration: none;
    }

    .fc-daygrid-day-number {
        color: #000;
        text-decoration: none;
    }

    .selected-date {
        background: #074F46 !important;
        color: white;
        border-radius: 5px;
    }

    .selected-time {
        background-color: #4CAF50 !important;
        color: white !important;
    }
</style>

<div class="h-full">
    <div class="h-12 bg-white"></div>

    <div class="mt-10 mx-10 flex justify-evenly items-center">
        <div id="calendar-container">
            <div id="calendar"></div>
        </div>

        <div class="bg-[#FFFFDB] p-4 rounded-md flex flex-col justify-between">
            <div>
                <p class="font-bold text-[20px]">Select Time</p>
                <form method="POST" action="{{ route('appointmentUpdate.reschedule', $appointment->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        $duration = $appointment->duration;
                        $timeSlots = ($duration == 60)
                            ? ['1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM', '8:00 PM', '9:00 PM', '10:00 PM', '11:00 PM']
                            : ['1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM',
                            '6:00 PM', '6:30 PM', '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM', '9:00 PM', '9:30 PM', '10:00 PM', '10:30 PM', '11:00 PM'];
                        $maxSlots = 3;
                    @endphp

                    <table class="w-[500px] border-collapse">
                        <tbody id="time-slots">
                            @foreach ($timeSlots as $index => $time)
                                @php
                                    $bookingCount = isset($bookedSlots[$time]) ? $bookedSlots[$time] : 0;
                                    $availableSlots = max(0, $maxSlots - $bookingCount);
                                    $isFullyBooked = $availableSlots <= 0;
                                    $isSelected = ($time == $appointment->appointment_time);
                                @endphp

                                @if ($index % 3 == 0)
                                    <tr>
                                @endif

                                <td class="border px-4 py-3 text-center {{ $isFullyBooked ? 'bg-[#F54C4C] text-white' : 'cursor-pointer time-option' }} {{ $isSelected ? 'selected-time' : '' }}"
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

                                @if ($index % 3 == 2 || $index == count($timeSlots) - 1)
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Hidden inputs for date and time -->
                    <input type="hidden" id="selected_date" name="selected_date" value="">
                    <input type="hidden" id="selected_time" name="selected_time" value="">

                    <!-- Buttons moved to bottom -->
                    <div class="flex justify-between mt-6 gap-2">
                        <a href="{{ route('booked.appointments') }}"
                            class="w-full px-4 py-2 rounded-md border-2 text-black border-black hover:bg-gray-300 text-center no-underline hover:text-white transition duration-300">
                            Cancel
                        </a>

                        <button type="submit"
                            class="w-full px-4 py-2 rounded-md border-2 border-black hover:bg-[#074F46] hover:text-white transition duration-300">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var preselectedDate = "{{ $appointment->date }}"; // Appointment date from database
        var preselectedTime = "{{ $appointment->time }}"; // Previously selected time

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            validRange: {
                start: new Date() // Prevent past dates from being selected
            },
            dateClick: function(info) {
                document.querySelectorAll('.selected-date').forEach(el => {
                    el.classList.remove('selected-date');
                });

                info.dayEl.classList.add('selected-date');

                // Set the selected date in the hidden input
                document.getElementById('selected_date').value = info.dateStr;
            },
            events: [{
                start: preselectedDate,
                display: 'background',
                color: '#FFCC00' // Highlight the current appointment date
            }],
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            }
        });

        calendar.render();

        // Auto-highlight the preselected date
        setTimeout(() => {
            let preselectedElement = document.querySelector(`[data-date="${preselectedDate}"]`);
            if (preselectedElement) {
                preselectedElement.classList.add('selected-date');
            }
        }, 500);

        // Auto-highlight the preselected time slot
        setTimeout(() => {
            let timeSlots = document.querySelectorAll('.time-option');
            timeSlots.forEach(slot => {
                let slotText = slot.querySelector('div:first-child').textContent.trim();
                if (slotText === preselectedTime) {
                    slot.classList.add('selected-time'); // Apply highlight class
                    document.getElementById('selected_time').value = preselectedTime; // Set hidden input value
                }
            });
        }, 500);
    });

    function selectTime(element, time) {
        document.querySelectorAll('.time-option').forEach(el => {
            el.classList.remove('selected-time');
        });

        element.classList.add('selected-time');
        document.getElementById('selected_time').value = time;
    }
</script>

@endsection
