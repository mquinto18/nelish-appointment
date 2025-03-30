@extends('layouts.user')

@section('title', 'Book Appointment')

@section('contents')
<style>
    body {
        background-color: #074F46;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .booking-summary,
    .payment-method {
        background-color: #FFFFDB;
        padding: 20px;
        border-radius: 8px;
        width: 45%;
        /* Adjust width as needed */
    }

    .payment-method {
        border-top: 2px solid #074F46;
    }

    .payment-options {
        display: flex;
        justify-content: space-evenly;
    }

    .payment-options label {
        font-size: 16px;
    }

    #gcashImage {
        display: none;
        text-align: center;
    }
</style>

<div>
    @include('appointment.navigation')
    <div>
        <h1 class="text-white text-center">Confirmation</h1>

        <div class="container">
            <!-- Booking Summary Section -->
            <div class="booking-summary">
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
                    <input type="hidden" name="therapist" value='@json($bookingData["therapist_name"])'>
                    <input type="hidden" name="amount" value="{{ $bookingData['amount'] }}">
                    @foreach($services as $service)
                    <input type="hidden" name="services[]" value="{{ $service }}">
                    @endforeach

                    <!-- Hidden field for payment method -->
                    <input type="hidden" name="payment_method" id="paymentMethod">

                    <div>
                        <p class="font-bold text-[18px]">Services</p>
                        <div class="px-2 leading-3">
                            <p class="font-medium">Selected Services:</p>
                            <ul class="ml-4 space-y-2">
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
                            <p class="font-medium">{{ \Carbon\Carbon::parse($bookingData['date'])->format('F d, Y') }}</p>
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

            <!-- Payment Method Section -->
            <div class="payment-method">
                <p class="font-bold text-[18px]">Payment Options</p>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="cash" class="mr-2" id="cashRadio">
                        Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="gcash" class="mr-2" id="gcashRadio">
                        Gcash
                    </label>
                </div>

                <!-- Gcash QR Code, hidden by default -->
                <div class="text-center mt-4" id="gcashImage" style="display:none;">
                    <img src="{{ asset('images/gcashQR.jpeg') }}" alt="Gcash QR Code" class="mx-auto">
                    <p class="mt-2 italic">Scan the QR code to complete your payment, then show the receipt to the spa.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const gcashRadio = document.getElementById('gcashRadio');
        const cashRadio = document.getElementById('cashRadio');
        const paymentMethodInput = document.getElementById('paymentMethod'); // Hidden input to hold the selected value
        const gcashImage = document.getElementById('gcashImage'); // Gcash QR Code section

        // Ensure the correct value is set when the user selects a radio button
        cashRadio.addEventListener('change', function() {
            if (cashRadio.checked) {
                paymentMethodInput.value = 'cash'; // Set payment method to 'cash'
                gcashImage.style.display = 'none'; // Hide Gcash QR code
            }
        });

        gcashRadio.addEventListener('change', function() {
            if (gcashRadio.checked) {
                paymentMethodInput.value = 'gcash'; // Set payment method to 'gcash'
                gcashImage.style.display = 'block'; // Show Gcash QR code
            }
        });
    });
</script>
@endsection