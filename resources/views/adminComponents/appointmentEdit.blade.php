@extends('layouts.admin')

@section('title', 'Edit Appointment')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>
<div class="shadow-lg shadow-black">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Edit Appointment</h1>
        <div class="bg-white w-full p-3 rounded-md">
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="name" class="form-label font-medium text-black block mb-2">Name</label>
                        <input type="text" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" name="name" value="{{ old('name', $appointment->name) }}" required>
                    </div>
                    <div>
                        <label for="email" class="form-label font-medium text-black block mb-2">Email</label>
                        <input type="email" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" value="{{ old('email', $appointment->email) }}" required>
                    </div>
                    <div>
                        <label for="therapist" class="form-label font-medium text-black block mb-2">Therapist</label>
                        <input type="text" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="therapist" name="therapist" value="{{ old('therapist', $appointment->therapist) }}" required>
                    </div>
                    <div>
                        <label for="services" class="form-label font-medium text-black block mb-2">Services</label>
                        <input type="text" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="services" name="services" value="{{ old('services', $appointment->services) }}" required>
                    </div>
                    <div>
                        <label for="date" class="form-label font-medium text-black block mb-2">Date</label>
                        <input type="date" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="date" name="date" value="{{ old('date', $appointment->date) }}" required>
                    </div>
                    <div>
                        <label for="time" class="form-label font-medium text-black block mb-2">Time</label>
                        <input type="time" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="time" name="time" value="{{ old('time', $appointment->time) }}" required>
                    </div>
                    <div>
                        <label for="amount" class="form-label font-medium text-black block mb-2">Amount</label>
                        <input type="number" step="0.01" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="amount" name="amount" value="{{ old('amount', $appointment->amount) }}" required>
                    </div>
                    <div>
                        <label for="quantity" class="form-label font-medium text-black block mb-2">Quantity</label>
                        <input type="number" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="quantity" name="quantity" value="{{ old('quantity', $appointment->quantity) }}" required>
                    </div>
                    <div>
                        <label for="duration" class="form-label font-medium text-black block mb-2">Duration</label>
                        <input type="text" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="duration" name="duration" value="{{ old('duration', $appointment->duration) }}" required>
                    </div>

                    <!-- Payment Proof Preview -->
                    <div>
                        <label for="payment_proof" class="form-label font-medium text-black block mb-2">Payment Proof</label>
                        <div class="mb-2">
                            @if ($appointment->payment_proof)
                            <p>Current Payment Proof:</p>
                            <!-- Thumbnail Image -->
                            <img src="{{ asset('storage/' . $appointment->payment_proof) }}"
                                alt="Payment Proof"
                                class="w-32 h-32 object-cover mt-2 cursor-pointer"
                                onclick="openModal('{{ asset('storage/' . $appointment->payment_proof) }}')">
                            @else
                            <p>No payment proof uploaded.</p>
                            @endif
                        </div>
                        <input type="file" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="payment_proof" name="payment_proof">
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="form-label font-medium text-black block mb-2">Payment Status</label>
                        <select class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="payment_status" name="payment_status" required>
                            <option value="paid" {{ old('payment_status', $appointment->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="not paid" {{ old('payment_status', $appointment->payment_status) == 'not paid' ? 'selected' : '' }}>Not Paid</option>
                        </select>
                    </div>

                </div>

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('viewAppointment') }}" class="bg-[#096156] no-underline w-full text-white p-2 rounded-md text-center block">
                        Cancel
                    </a>
                    <button type="submit" class="bg-[#096156] w-full text-white p-2 rounded-md">Save</button>
                </div>

                <!-- Modal -->
                <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden" onclick="closeModal(event)">
                    <div class="relative">
                        <img id="modalImage" src="" class="max-w-full max-h-screen rounded-lg">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openModal(imageSrc) {
        document.getElementById("modalImage").src = imageSrc;
        document.getElementById("imageModal").classList.remove("hidden");
    }

    function closeModal(event) {
        // Close only if clicking outside the image
        if (event.target.id === "imageModal") {
            document.getElementById("imageModal").classList.add("hidden");
        }
    }
</script>
@endsection