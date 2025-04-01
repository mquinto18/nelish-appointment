<!DOCTYPE html>
<html lang="en">

<head>
    @notifyCss
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Forgot Password</title>
</head>

<style>
    body {
        background-color: #096156;
    }
</style>

<body class="flex items-center justify-center min-h-screen px-4 ">
    <div class="w-[500px] max-w-md bg-white p-6 shadow-lg rounded-lg">
        
        <!-- Title Section -->
        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-800">Forgot Password?</h2>
            <p class="text-sm text-gray-600">Enter your email to reset your password.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 mt-4 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form method="post" action="{{ route('password.email') }}" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email Address</label>
                <input type="email" name="email" id="email" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter your email" required>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition duration-200">Reset Password</button>
        </form>

        <!-- Back to Login -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Back to Login</a>
        </div>
    </div>
</body>

</html>
