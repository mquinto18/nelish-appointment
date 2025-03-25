@extends('layouts.user')

@section('title', 'Settings')

@section('contents')
<div class="flex justify-center items-center min-h-screen bg-[#0B3D32]">
    <div class="bg-[#20543E] p-8 rounded-2xl w-[50%] shadow-lg my-3">
        <h1 class="text-white text-2xl font-semibold mb-5">My Account</h1>

        <!-- Account Details Form -->
        <div class="bg-[#2F614B] p-6 rounded-xl text-white">
            <h2 class="text-lg font-semibold mb-4">Account Details</h2>

            <form id="account-form" method="POST" action="{{ route('account.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-2">
                        <span>Profile:</span>
                        <span class="bg-white text-black px-3 py-1 rounded-md"><i class="fas fa-user"></i></span>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">First Name:</label>
                        <input type="text" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">Last Name:</label>
                        <input type="text" name="last_name" value="{{ auth()->user()->last_name ?? '' }}" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">Gender:</label>
                        <select name="gender" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ auth()->user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>


                    <div class="flex flex-col col-span-2">
                        <label class="text-sm">Email:</label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                    </div>


                    <div class="flex flex-col">
                        <label class="text-sm">Birth Date:</label>
                        <input type="date" name="birth_date" value="{{ auth()->user()->birth_date ?? '' }}" class="bg-white text-black px-3 py-1 rounded-md w-full">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">Mobile Number:</label>
                        <input type="text" name="mobile_number" value="{{ auth()->user()->mobile_number ?? '' }}" class="bg-white text-black px-3 py-1 rounded-md w-full">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-4">
                    <button type="submit" id="change-btn" class="bg-yellow-500 text-black px-4 py-2 rounded-md font-semibold">Change</button>
                </div>
            </form>


        </div>

        <!-- Security Form -->
        <div class="bg-[#2F614B] p-6 rounded-xl text-white mt-6">
            <h2 class="text-lg font-semibold mb-4">Security</h2>



            <form id="security-form" method="POST" action="{{ route('account.password') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Old Password:</label>
                        <input type="password" name="old_password" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                        @error('old_password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">New Password:</label>
                        <input type="password" name="new_password" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                        @error('new_password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm">Confirm Password:</label>
                        <input type="password" name="new_password_confirmation" class="bg-white text-black px-3 py-1 rounded-md w-full" required>
                        @error('new_password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-[#E0E0E0] text-black px-6 py-2 rounded-md font-semibold">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>



@endsection