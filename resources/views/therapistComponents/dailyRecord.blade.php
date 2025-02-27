@extends('layouts.therapist')

@section('title', 'Therapist')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="shadow-lg shadow-black">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Daily Time Record</h1>
    </div>

    <!-- Start Form -->
    <form action="{{ route('therapist.dtr') }} " method="POST">
        @csrf <!-- Include CSRF token for security -->
        <div class="bg-white w-full p-5 rounded-md">
            <!-- Date Selection -->
            <div>
                <label for="date" class="form-label font-medium text-black block mb-2">Select a date (MM/DD/YYYY)</label>
                <input type="date" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="date" name="date" required>
            </div>

            <!-- Time In & Time Out -->
            <div class="flex gap-2 mt-3">
                <div class="w-full">
                    <label for="time_in" class="form-label font-medium text-black block mb-2">Time In</label>
                    <input type="time" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="time_in" name="time_in" required>
                </div>
                <div class="w-full">
                    <label for="time_out" class="form-label font-medium text-black block mb-2">Time Out</label>
                    <input type="time" class="form-control block w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="time_out" name="time_out" required>
                </div>
            </div>

            <!-- Work Description -->
            <div class="mt-4">
                <textarea class="form-control w-full border-2 border-gray-300 rounded-lg px-3 py-2 bg-gray-100"
                    id="work_description" name="work_description" placeholder="Work description (optional)"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-[#096156] mt-4 w-full text-white p-2 rounded-md">Submit</button>
        </div>
    </form>
    <!-- End Form -->
</div>

<script>
    // Set today's date as default
    document.getElementById('date').value = new Date().toISOString().split('T')[0];
</script>
@endsection
