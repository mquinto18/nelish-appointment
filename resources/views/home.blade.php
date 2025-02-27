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

        <div class="p-5 lg:p-10 max-w-[1600px] mx-auto">
            <h1 class="font-bold text-[20px] sm:text-2xl md:text-3xl lg:text-3xl text-black text-center">Our Services</h1>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">DEEP TISSUE MASSAGE</h2>
                    <p class="text-black text-sm">Target the deeper layers of muscles and connective tissue.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">SHIATSU DRY MASSAGE</h2>
                    <p class="text-black text-sm">A therapeutic, hands-on treatment rooted in ancient Japanese healing techniques.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md relative">
                    <h2 class="font-bold text-lg text-black">AROMATHERAPY W/ HOT COMPRESS <span class="text-yellow-500">⭐</span></h2>
                    <p class="text-black text-sm">Combines the soothing power of essential oils with the therapeutic benefits of a heated compress to deliver an indulgent and deeply relaxing experience.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">VENTOSA WITH MASSAGE</h2>
                    <p class="text-black text-sm">A unique and therapeutic treatment that combines the ancient art of cupping with the soothing benefits of a massage.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">FOOT REFLEX</h2>
                    <p class="text-black text-sm">A relaxing and therapeutic treatment based on the principle that specific points on the feet correspond to various organs and systems of the body.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md relative">
                    <h2 class="font-bold text-lg text-black">BODY SCRUB W/ WHOLE BODY MASSAGE <span class="text-yellow-500">⭐</span></h2>
                    <p class="text-black text-sm">A luxurious treatment that combines exfoliation with a relaxing massage to leave your skin feeling smooth, revitalized, and nourished.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">HEAD AND FACE MASSAGE W/ EAR CANDLING</h2>
                    <p class="text-black text-sm">A holistic treatment designed to promote relaxation, balance, and clarity.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">KIDS RELAXING MASSAGE</h2>
                    <p class="text-black text-sm">A gentle, nurturing treatment designed specifically for children to help them unwind, relieve tension, and promote a sense of calm.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">LAVA STONE MASSAGE</h2>
                    <p class="text-black text-sm">A deeply soothing and therapeutic treatment that uses heated volcanic stones to provide a unique and powerful form of relaxation.</p>
                </div>

                <div class="bg-[#BBD493] p-4 rounded-lg shadow-md">
                    <h2 class="font-bold text-lg text-black">FOOT SCRUB W/ MASSAGE</h2>
                    <p class="text-black text-sm">A refreshing treatment that focuses on revitalizing your feet, leaving them soft, smooth, and tension-free.</p>
                </div>
            </div>
        </div>



        <div class="bg-[#074E45]">
            <div class="max-w-[1600px] mx-auto p-5">
                <div class="flex justify-between items-center">
                    <div class="w-[350px]">
                        <img src="{{ asset('images/mainLogo.png') }}" alt="" class='w-[80px]'>
                        <p class="font-medium text-[20px]">Where tranquility and rejuvenation meet luxury.</p>

                        <div class="flex flex-row gap-3">
                            <i class="fa-brands fa-facebook-f text-[25px]" style="color: #ffffff;"></i>
                            <i class="fa-solid fa-envelope text-[25px]" style="color: #ffffff;"></i>
                            <i class="fa-brands fa-square-instagram text-[25px]" style="color: #ffffff;"></i>
                        </div>
                    </div>

                    <div>
                        <h1 class="text-[20px] mb-4">Navigate</h1>

                        <div class="flex flex-col gap-3">
                            <a href="" class="no-underline text-white">Home</a>
                            <a href="" class="no-underline text-white">About</a>
                            <a href="" class="no-underline text-white">Services</a>
                        </div>
                    </div>

                    <div>
                        <h1 class="text-[20px]">Contact</h1>
                        <div>
                            <div class="flex items-center gap-4 text-white">
                                <i class="fa-solid fa-clock"></i>
                                <p class="text-base">1:00 PM to 1:00 AM</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-phone-volume" style="color: #ffffff;"></i>
                                <p>0918 250 8629 | 090994 638 0620</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-location-dot" style="color: #ffffff;"></i>
                                <p>Hotel Lucky Chinatown 6th Floor
                                    21 Reina Regente St. Brgy 293
                                    Binondo Manila</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection