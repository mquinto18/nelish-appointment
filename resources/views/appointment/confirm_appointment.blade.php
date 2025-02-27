@extends('layouts.user')

@section('title', 'Book Appointment')

@section('contents')
<style>
    body {
        background-color: #074F46;
    }
</style>

<div>
    @include('appointment.navigation')
    <div>
        <h1 class="text-white text-center">Confirmation</h1>

        <div class="flex justify-center">
            <div class="bg-[#FFFFDB] p-4 w-[500px] rounded-md">
                <p class="font-bold text-[20px]">Your Booking Summary</p>

                @php
                // Decode services from JSON if stored as a string
                $services = is_string($bookingData['services']) ? json_decode($bookingData['services'], true) : $bookingData['services'];
                @endphp

                <form action="{{ route('appointment.ConfirmStore') }}" method="POST">
                    @csrf <!-- Laravel CSRF protection -->

                    <!-- Hidden Inputs to Pass Data -->
                    <input type="hidden" name="duration" value="{{ $bookingData['duration'] }}">
                    <input type="hidden" name="quantity" value="{{ $bookingData['quantity'] }}">
                    <input type="hidden" name="date" value="{{ $bookingData['date'] }}">
                    <input type="hidden" name="time" value="{{ $bookingData['time'] }}">
                    <input type="hidden" name="therapist" value="{{ $bookingData['therapist_name'] }}"> <!-- FIXED -->
                    <input type="hidden" name="amount" value="{{ $bookingData['amount'] }}">

                    <!-- Loop through services and add them as hidden inputs -->
                    @foreach($services as $service)
                        <input type="hidden" name="services[]" value="{{ $service }}">
                    @endforeach

                    <div>
                        <p class="font-medium text-[18px]">Services</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Selected Services: {{ implode(', ', $services) }}</p>
                            <p class="font-medium">Duration: {{ $bookingData['duration'] }} Minutes</p>
                            <p class="font-medium">Person: {{ $bookingData['quantity'] }} Person(s)</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-medium text-[18px]">Booking Appointment</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Month & Year: {{ \Carbon\Carbon::parse($bookingData['date'])->format('F Y') }}</p>
                            <p class="font-medium">Day: {{ \Carbon\Carbon::parse($bookingData['date'])->format('l') }}</p>
                            <p class="font-medium">Time: {{ \Carbon\Carbon::parse($bookingData['time'])->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-medium text-[18px]">Therapist</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Therapist: {{ $bookingData['therapist_name'] }}</p>
                            <p class="font-medium">Total Fee: {{ $bookingData['amount'] }} Pesos</p>
                        </div>
                    </div>

                    <button type="submit" class="bg-[#074F46] w-full text-white p-2 my-3 rounded-full">
                        Confirm Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Debugging: Confirm Form Submission -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        console.log("Form is submitting...");
    });
});
</script>

@endsection
