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

        
        <div class="flex justify-center items-center gap-5">
            <div class="bg-[#FFFFDB] p-4 w-[500px] rounded-md">
                <p class="font-bold text-[20px]">Your Booking Summary</p>

                @php
                $services = is_string($bookingData['services']) ? json_decode($bookingData['services'], true) : $bookingData['services'];
                @endphp

                <form action="{{ route('appointment.ConfirmStore') }}" method="POST">
                    @csrf
                    <input type="hidden" name="duration" value="{{ $bookingData['duration'] }}">
                    <input type="hidden" name="quantity" value="{{ $bookingData['quantity'] }}">
                    <input type="hidden" name="date" value="{{ $bookingData['date'] }}">
                    <input type="hidden" name="time" value="{{ $bookingData['time'] }}">
                    <input type="hidden" name="therapist" value="{{ $bookingData['therapist_name'] }}">
                    <input type="hidden" name="amount" value="{{ $bookingData['amount'] }}">
                    @foreach($services as $service)
                    <input type="hidden" name="services[]" value="{{ $service }}">
                    @endforeach

                    <div>
                        <p class="font-bold text-[18px]">Services</p>
                        <div class="px-2 leading-3">
                        <p class="font-medium">Selected Services:</p>
                            <ul class="ml-4 space-y-2"> <!-- Added spacing between list items -->
                                @foreach($services as $service)
                                    <li class="mb-1">• {{ $service }}</li>
                                @endforeach
                            </ul>
                            <p class="font-medium">Duration: {{ $bookingData['duration'] }} Minutes</p>
                            <p class="font-medium">Person: {{ $bookingData['quantity'] }} Person(s)</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-bold text-[18px]">Booking Appointment</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Month & Year: {{ \Carbon\Carbon::parse($bookingData['date'])->format('F Y') }}</p>
                            <p class="font-medium">Day: {{ \Carbon\Carbon::parse($bookingData['date'])->format('l') }}</p>
                            <p class="font-medium">Time: {{ \Carbon\Carbon::parse($bookingData['time'])->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-bold text-[18px]">Therapist</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Therapist: {{ $bookingData['therapist_name'] }}</p>
                            <p class="font-medium">Total Fee: {{ $bookingData['amount'] }} Pesos</p>
                        </div>
                    </div>


                    <div class="flex gap-2">

                        <button type="submit" class="bg-[#074F46] w-full text-white p-2 my-3 rounded-md">
                            Confirm Appointment
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-[#FFFFDB] px-4 pb-4 w-[500px] rounded-md">
                <p class="font-bold text-[20px] mt-4">Payment Options</p>
                <div class="flex gap-2">
                    <form action="{{ route('paymongo.gcash') }}" method="POST" class="w-full" target="_blank">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $bookingData['amount'] * 100 }}">

                        <button type="submit" class="border-2 w-full border-gray-300 px-4 py-2 h-16 rounded-lg hover:border-blue-500 transition duration-300 flex items-center justify-center space-x-2">
                            <img src="{{ asset('images/gcash-logo.png') }}" alt="GCash Logo" class="w-20 h-auto">
                            <span class="text-lg font-medium flex items-center space-x-2">
                                <span>/</span>
                                <i class="fa-solid fa-credit-card text-lg"></i>
                                <span>Credit or Debit Card</span>
                            </span>
                        </button>
                    </form>


                    <!-- <form action="{{ route('paymongo.bank') }}" method="POST" class="w-full" target="_blank">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $bookingData['amount'] * 100 }}">
                        <button type="submit" class="border-2 w-full border-gray-300 px-4 py-2 h-16 rounded-lg hover:border-blue-500 transition duration-300 flex items-center justify-center">
                            <i class="fa-solid fa-credit-card text-lg"></i>
                            <span class="ml-2">Credit or Debit Card</span>
                        </button>
                    </form> -->
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("form").addEventListener("submit", function(event) {
            console.log("Form is submitting...");
            alert("Your appointment has been successfully booked!");
        });
    });
</script>

@endsection