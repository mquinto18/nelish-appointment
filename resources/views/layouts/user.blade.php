<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body>
    <div>
        <nav class="bg-[#074E45]">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <img src="{{ asset('images/mainLogo.png') }}" alt="" class='w-[80px]'>

                    <div class="no-underline">
                        <a href="{{ url('/') }}" class="text-white px-3 py-2 rounded-md text-sm no-underline">Home</a>
                        <a href="#" class="text-white hover:text-white px-3 py-2 rounded-md text-sm no-underline">About Us</a>
                        <a href="#" class="text-white hover:text-white px-3 py-2 rounded-md text-sm no-underline">Services</a>
                        <a href="#" class="text-white hover:text-white px-3 py-2 rounded-md text-sm no-underline">Contact</a>
                    </div>

                    @if(Auth::check())
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn bg-white d-flex align-items-center rounded-circle p-2" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="profileDropdown">
                            <li class="p-3">
                                <h5 class="mt-2 mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                                <p class="text-muted small mt-1 mb-0">{{ Auth::user()->email }}</p>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="mx-4">
                                <form method="POST" action="{{ route('logout') }}" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <!-- Login/Register Links -->
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-white px-3 py-2 rounded-md text-sm no-underline">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-white px-3 py-2 rounded-md text-sm no-underline">Register</a>
                    </div>
                    @endif
                </div>
            </div>
        </nav>

        <div>@yield('contents')</div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>