@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<style>
    body {
        background-color: #074F46;
    }
</style>
<div>
    @include('appointment.navigation')
    <h1 class="text-white text-center">Time and Therapist</h1>
    <form action="{{ route('your_route_here') }}" method="POST">
    @csrf
    <input type="hidden" name="selected_time" id="selected_time">
    <input type="hidden" name="selected_therapist" id="selected_therapist">

    <div class="flex gap-10 justify-center p-6">
        <!-- Time Selection -->
        <div class="bg-[#FFFFDB] ">
            <table class="border-none border w-[500px] ">
                <p class="px-3 pt-4 font-bold text-[20px]">Select time</p>
                <div class="flex items-center px-4 rounded-lg">
                    <div class="w-3 h-3 bg-red-500 mr-3"></div>
                    <span class="text-black text-sm font-medium">Unavailable Timeslots</span>
                </div>
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
                    '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM', '9:00 PM', '9:30 PM',
                    '10:00 PM', '10:30 PM', '11:00 PM', '11:30 PM', '12:00 AM', '12:30 AM', '1:00 AM'
                    ] as $time)
                    <tr>
                        <td class="border px-4 py-2 cursor-pointer text-center" onclick="selectTime('{{ $time }}')">{{ $time }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" onclick="selectTime('{{ $time }}')">Choose</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Therapist Selection -->
        <div class="bg-[#FFFFDB] h-[1000px]">
            <p class="px-3 pt-4 font-bold text-[20px]">Select Therapist</p>
            <div class="grid grid-cols-3 px-3 gap-5">
                @foreach ($therapists as $therapist)
                <div class="bg-[#074F46] py-5 px-3 flex flex-col rounded-t-full rounded-r-full rounded-bl-none cursor-pointer therapist-card" onclick="selectTherapist('{{ $therapist->id }}', '{{ $therapist->name }}')">
                    <i class="fa-solid fa-circle-user text-[90px] text-center" style="color: #ffffff;"></i>
                    <div class="text-white text-center leading-[5px] mt-4">
                        <p class="font-bold text-[15px]">{{ $therapist->name }}</p>
                        <p class="text-[13px]">{{ $therapist->bio }}</p>
                    </div>
                    <div class="leading-[5px] text-white mt-3">
                        <p class="text-[13px]">Phone Number: {{ $therapist->phone }}</p>
                        <p class="text-[13px]">Email Address: {{ $therapist->email }}</p>
                        <p class="text-[13px]">Experience: {{ $therapist->experience }}</p>
                        <p class="text-[13px]">Language Spoken: {{ $therapist->language }}</p>
                    </div>
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
    function selectTime(time) {
        alert("You selected: " + time);
    }
</script>

@endsection