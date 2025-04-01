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

                <form action="{{ route('appointment.ConfirmStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="duration" value="{{ $bookingData['duration'] }}">
                    <input type="hidden" name="quantity" value="{{ $bookingData['quantity'] }}">
                    <input type="hidden" name="date" value="{{ $bookingData['date'] }}">
                    <input type="hidden" name="time" value="{{ $bookingData['time'] }}">
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
                        <div class="px-2 leading-3">

                            <p class="font-medium">Total Fee: {{ $bookingData['amount'] }} Pesos</p>
                        </div>
                    </div>
                    <!-- File Upload Input -->
                    <div class="mb-4">
                        <label class="font-medium">Upload Payment Proof (if applicable):</label>
                        <input type="file" name="payment_proof" id="paymentProofInput" class="mt-2 block w-full border p-2 rounded-md" accept="image/*" onchange="previewImage()">
                    </div>

                    <!-- Image Preview -->
                    <img id="imagePreview" src="" alt="Uploaded Image Preview" class="mx-auto mt-2 rounded-md" width="300" style="display: none;">

                    <div class="flex gap-2">
                        <button type="submit" class="bg-[#074F46] w-full text-white p-2 my-3 rounded-md">
                            Confirm Appointment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Method Section -->
            <div class="payment-method">
                <div class="">
                    <p class="font-bold text-[18px]">Payment Options</p>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="payment_method" value="cash" class="mr-2" id="cashRadio" onchange="togglePaymentMethod()">
                            Cash
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="gcash" class="mr-2" id="gcashRadio" onchange="togglePaymentMethod()">
                            Gcash
                        </label>
                    </div>
                </div>

                <!-- Gcash QR Code, hidden by default -->
                <div class="text-center mt-4" id="gcashImage" style="display:none;">
                    <img src="{{ asset('images/gcashPayment.png') }}" alt="Gcash QR Code" class="mx-auto" width="300">
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
        const paymentProofInput = document.getElementById('paymentProofInput'); // File input
        const imagePreview = document.getElementById('imagePreview'); // Image preview

        // Ensure the correct value is set when the user selects a radio button
        cashRadio.addEventListener('change', function() {
            if (cashRadio.checked) {
                paymentMethodInput.value = 'cash'; // Set payment method to 'cash'
                gcashImage.style.display = 'none'; // Hide Gcash QR code section
                imagePreview.style.display = 'none'; // Hide image preview
                paymentProofInput.value = ''; // Reset file input
            }
        });

        gcashRadio.addEventListener('change', function() {
            if (gcashRadio.checked) {
                paymentMethodInput.value = 'gcash'; // Set payment method to 'gcash'
                gcashImage.style.display = 'block'; // Show Gcash QR code section
            }
        });

        // Handle image preview
        paymentProofInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    });
</script>

@endsection