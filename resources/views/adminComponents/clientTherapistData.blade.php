@extends('layouts.admin')

@section('title', 'Client and Therapist')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>
<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Client and Therapist </h1>

        <div class="flex gap-4 p-3">
            <!-- Client Account Section -->
            <div class="bg-white w-full p-3 rounded-md">
                <h1 class="text-[20px] text-center">Client Account</h1>

                <div class="mx-10 py-3">
                    @foreach ($clients as $client)
                    <div class="bg-[#074E45] text-white py-3 px-4 rounded-lg w-full mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-circle-user text-[30px]"></i>
                            </div>
                            <div class="text-[15px]">
                                {{ $client->first_name }} {{ $client->last_name }}
                            </div>
                            <button class="toggleButton bg-white py-1 px-4 text-black rounded-md">View</button>
                        </div>

                        <div class="adminDetails leading-3 mt-6 hidden">
                            <p>Email: {{ $client->email }}</p>
                            <p>Birth Date: {{ $client->birth_date ?? 'N/A' }}</p>
                            <p>Number: {{ $client->mobile_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pending Admins Section -->
            <!-- Therapist Account Section -->
            <div class="bg-white w-full p-3 rounded-md">
                <h1 class="text-[20px] text-center">Therapist Account</h1>

                <div class="mx-10 py-3">
                    @foreach ($therapists as $therapist)
                    <div class="bg-[#074E45] text-white py-3 px-4 rounded-lg w-full mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-circle-user text-[30px]"></i>
                            </div>
                            <div class="text-[15px]">
                                {{ $therapist->name }}
                            </div>
                            <button class="toggleButton bg-white py-1 px-4 text-black rounded-md">View</button>
                        </div>

                        <div class="adminDetails leading-3 mt-6 hidden">
                            <p>Email: {{ $therapist->email }}</p>
                            <p>Specialization: {{ $therapist->specialization ?? 'N/A' }}</p>
                            <p>Phone: {{ $therapist->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    document.querySelectorAll(".toggleButton").forEach((button, index) => {
        button.addEventListener("click", function() {
            document.querySelectorAll(".adminDetails")[index].classList.toggle("hidden");
        });
    });
</script>

@endsection