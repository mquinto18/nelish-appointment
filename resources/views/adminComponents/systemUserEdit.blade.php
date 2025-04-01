@extends('layouts.admin')

@section('title', 'Edit System User')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>
<div class="shadow-lg shadow-black">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Edit System User</h1>
        <div class="bg-white w-full p-3 rounded-md">
            <form action="{{ route('systemUser.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Mobile Number -->
                    <div class="mb-4">
                        <label for="mobile_number" class="block text-gray-700">Mobile Number</label>
                        <input type="text" id="mobile_number" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Gender -->
                    <div class="mb-4">
                        <label for="gender" class="block text-gray-700">Gender</label>
                        <select id="gender" name="gender" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Birthdate -->
                    <div class="mb-4">
                        <label for="birth_date" class="block text-gray-700">Birthdate</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('systemUser') }}" class="bg-[#096156] no-underline w-full text-white p-2 rounded-md text-center block">
                        Cancel
                    </a>
                    <button type="submit" class="bg-[#096156] w-full text-white p-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection