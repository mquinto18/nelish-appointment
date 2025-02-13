@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<style>
    .card-img-overlay {
        transition: opacity 0.3s ease-in-out;
    }

    .hover-overlay:hover {
        opacity: 1 !important;
    }
</style>

<div>
    <div class="relative w-full h-[500px] sm:h-[600px] md:h-[700px] text-white">
        <img src="{{ asset('images/login_background.jfif') }}" alt="Clinic Image" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Dark overlay -->
        <div class="absolute inset-0 flex flex-col gap-4 justify-center items-center px-4 sm:px-8 lg:px-0 text-white">
            <h2 class="text-center text-2xl sm:text-2xl md:text-3xl lg:text-5xl font-semibold leading-tight">
                Best Relax And Spa Zone.
            </h2>
            <span class="text-center text-[12px] sm:text-base md:text-lg max-w-[90%] sm:max-w-[600px] font-medium">
                You are going on a cruise, but when the ship sets sails, you discover it has no rudder. </span>
            <a href="{{ route('appointment.user') }}" class="bg-white text-black no-underline text-sm sm:text-base py-2 px-5 sm:px-7 font-medium rounded-full">
                Set Appointment
            </a>
        </div>

        <div class="p-5 lg:p-10 max-w-[1600px] mx-auto ">
            <div class="mb-[30px] text-black text-center">
                <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl">THE NELISH SERENITY SPA</h1>
                <p class="italic text-[20px]"> At Nelish Serenity Spa, we are dedicated to offering you a serene escape from the demands of everyday life,
                    ensuring a harmonious blend of relaxation, healing, and beauty.</p>
                <div class="row g-4 py-10">
                    <!-- First Image -->
                    <div class="col-md-4 position-relative">
                        <div class="card">
                            <img src="{{ asset('images/login_background.jfif') }}" alt="Jacuzzi" class="card-img rounded">
                            <div class="card-img-overlay d-flex align-items-end justify-content-center bg-[#064335] bg-opacity-50 text-white opacity-0 hover-overlay">
                                <h5 class="fw-bold text-uppercase">Jacuzzi</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Second Image -->
                    <div class="col-md-4 position-relative">
                        <div class="card">
                            <img src="{{ asset('images/login_background.jfif') }}" alt="Steam" class="card-img rounded">
                            <div class="card-img-overlay d-flex align-items-end justify-content-center bg-[#064335] bg-opacity-50 text-white opacity-0 hover-overlay">
                                <h5 class="fw-bold text-uppercase">Steam</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Third Image -->
                    <div class="col-md-4 position-relative">
                        <div class="card">
                            <img src="{{ asset('images/login_background.jfif') }}" alt="Sauna" class="card-img rounded">
                            <div class="card-img-overlay d-flex align-items-end justify-content-center bg-[#064335] bg-opacity-50 text-white opacity-0 hover-overlay">
                                <h5 class="fw-bold text-uppercase">Sauna</h5>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <div class="bg-[#074E45] h-auto lg:h-90">
            <div class="p-5 lg:p-10 max-w-[1800px] mx-auto">
                <div class="flex justify-center items-center gap-5">
                    <!-- Card 1 -->
                    <div>
                        <img src="{{ asset('images/login_background.jfif') }}" alt="Sauna" class="card-img rounded">

                    </div>
                    <div class="flex flex-col gap-8">
                        <h1 class="font-semibold text-[39px]">Conforming to high
                        standards of excellence</h1>
                        <p class="text-[20px]">Today, it fulfills its promise of complete wellness with relaxation, fitness, and beauty centers all stationed in one home, The Nelish Serenity Spa.</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection