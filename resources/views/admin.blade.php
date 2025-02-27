@extends('layouts.admin')

@section('title', 'Admin')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="shadow-lg shadow-black ">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Welcome Admin!</h1>
    </div>

    <div class="flex gap-4 p-3">
        <div class="bg-white w-full p-3 rounded-md">
            <h1 class="text-[20px] text-center">Manage Acccount</h1>

            <div class="mx-10 py-3">
                <h1 class="text-[20px]">Employee List</h1>

                @foreach ($admins as $admin)
                <div class="bg-[#074E45] text-white py-3 px-4 rounded-lg w-full mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <i class="fa-solid fa-circle-user text-[30px]"></i>
                        </div>
                        <div class="text-[15px]">
                            {{ $admin->first_name }} {{ $admin->last_name }}
                        </div>
                        <button class="toggleButton bg-white py-1 px-4 text-black rounded-md">View</button>
                    </div>

                    <div class="adminDetails leading-3 mt-6 hidden">
                        <p>Email: {{ $admin->email }}</p>
                        <p>Birth Date: {{ $admin->birth_date ?? 'N/A' }}</p>
                        <p>Number: {{ $admin->mobile_number ?? 'N/A' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pending Admins Section -->
        <div class="bg-white w-full p-3 rounded-md">
            <h1 class="text-[20px] text-center">Pending Admin Approvals</h1>

            <div class="mx-10 py-3 ">
                <h1 class="text-[20px]">Pending Employee List</h1>

                @foreach ($pendingAdmins as $admin)
                <div class="bg-[#074E45] text-black py-3 px-4 rounded-lg w-full mb-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <i class="fa-solid fa-circle-user text-[30px] text-white"></i>
                        </div>
                        <div class="text-[15px]">
                            {{ $admin['first_name'] }} {{ $admin['last_name'] }}
                        </div>
                        <button class="toggleButton bg-white py-1 px-4 text-black rounded-md">View</button>
                    </div>

                    <div class="adminDetails leading-3 mt-6 hidden">
                        <p>Email: {{ $admin['email'] }}</p>
                        <p>Birth Date: {{ $admin['birth_date'] ?? 'N/A' }}</p>
                        <p>Number: {{ $admin['mobile_number'] ?? 'N/A' }}</p>
                    </div>

                    <!-- Approve Button -->
                    <div class="flex justify-center gap-2 mt-3">
                        <form action="{{ route('approve.admin', $admin['email']) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded-md w-[200px]">Accept</button>
                        </form>

                        <form action="{{ route('reject.admin', $admin['email']) }}" method="POST" class="mt-2 inline-block">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded-md w-[200px]">Void</button>
                        </form>
                    </div>
                </div>
                @endforeach
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