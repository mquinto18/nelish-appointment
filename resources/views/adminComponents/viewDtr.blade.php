@extends('layouts.admin')

@section('title', 'Appointment')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>
<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Therapist DTR</h1>
    </div>
    <div class="bg-white p-4 rounded-lg">
        @foreach($managers as $manager)
        <div class="bg-[#074E45] text-white py-3 px-4 rounded-lg w-full mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fa-solid fa-circle-user text-[30px]"></i>
                </div>
                <div class="text-[15px]">
                    {{ $manager->first_name }}
                </div>
                <!-- View DTR Button (Only Visible When Table is Open) -->
                <div class="">
                    <a href="{{ route('dtr.view', ['therapist' => $manager->first_name]) }}" class="bg-white py-1 px-4 text-black rounded-md no-underline mt-3">View DTR</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


@endsection