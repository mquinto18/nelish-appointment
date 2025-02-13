@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<style>
    body {
        background-color: #074F46;
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
        /* Remove highlight */
        text-decoration: none;
    }

    .fc-daygrid-day-number {
        color: #000;
        /* Ensure numbers are visible */
        text-decoration: none;
    }

    .fc-daygrid-day.fc-day-today {
        background: #074F !important;
        color: white;
        border-radius: 5px;
        text-decoration: none;
    }

    .selected-date {

        background: #074F46 !important;
        color: white;
        border-radius: 5px;
    }

    .selected-date {
        background: #074F46 !important;
        color: white;
        border-radius: 5px;
    }
</style>

<div>
    @include('appointment.navigation')

    <div class="p-10">
        <h1 class="text-white text-center">Select Preferred Date:</h1>

        <div class="flex justify-center items-center gap-10">
            <div id="calendar-container">
                <div id="calendar"></div>
            </div>

            <form action="{{ route('appointment.storeDate') }}" method="POST" class="bg-[#F5F5DC] p-4 rounded-lg">
                @csrf
                <h1 class="text-[25px]">Booking Summary</h1>
                
                @if(!empty($bookingData))
                    <div class="bg-[#DADAAB] p-2 my-2">
                        Service: {{ implode(', ', $bookingData['services']) }}<br>
                        Duration: {{ $bookingData['duration'] }} Minutes<br>
                        Quantity: {{ $bookingData['quantity'] }} Person(s)<br>
                        Total Amount: {{ number_format($bookingData['amount'], 2) }} Pesos<br>
                    </div>
                @else
                    <p>No booking data available.</p>
                @endif
                
                <input type="hidden" name="selected_date" id="selected_date">
                <button type="submit" class="bg-[#FF9800] no-underline text-white px-4 py-2 block w-full text-center rounded hover:bg-blue-600 transition duration-300">
                    Submit Date
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var selectedDateInput = document.getElementById('selected_date');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            dateClick: function(info) {
                var previouslySelected = document.querySelector('.selected-date');
                if (previouslySelected) {
                    previouslySelected.classList.remove('selected-date');
                }

                info.dayEl.classList.add('selected-date');
                selectedDateInput.value = info.dateStr;
            },
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            }
        });
        calendar.render();
    });
</script>
@endsection
