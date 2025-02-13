<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nelish Serenity Spa - Login</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #074E45;
        margin: 0;
        color: white;
    }

    /* Navbar */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 50px;
        background-color: #00593E;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .logo {
        height: 50px;
    }

    .nav-links {
        display: flex;
        gap: 20px;
        list-style: none;
    }

    .nav-links a {
        text-decoration: none;
        color: white;
        font-weight: bold;
        transition: color 0.3s;
    }

    .nav-links a:hover {
        color: #FFD700;
    }

    .book-now-btn {
        background-color: #FFD700;
        color: #00593E;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s, background-color 0.3s;
    }

    .book-now-btn:hover {
        transform: scale(1.1);
        background-color: #FFC300;
    }

    /* Login Container */
    .login-container {
        display: flex;
        flex-wrap: wrap;
        /* Ensures that the image and form wrap on small screens */
        height: calc(100vh - 80px);
    }

    .image-section {
        flex: 1;
        position: relative;
        overflow: hidden;
        min-height: 400px;
    }

    .image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .form-section {
        flex: 1;
        padding: 50px;
        background-color: #074E45;
        /* Background color */
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Center content vertically */
        align-items: center;
        /* Center content horizontally */
        color: #F5F5DC;
        /* Text color */
        position: relative;
        overflow: hidden;
        /* Prevent overflow */
        z-index: 1;
        /* Ensure it stays above the logo */
    }

    .form-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/images/Logo.png');
        /* Correct file path */
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        opacity: 0.22;
        /* Logo transparency */
        z-index: -1;
        /* Ensure it stays behind everything */
    }

    .forgot-password,
    .register-link a {
        color: #CBC4A4;
        /* Updated color for Forgot Password and Register Here */
        text-decoration: underline;
        /* Add underline for visibility */
        font-weight: bold;
        transition: color 0.3s;
    }

    .forgot-password:hover,
    .register-link a:hover {
        color: #FFD700;
        /* Hover color */
        text-decoration: underline;
        /* Keep underline on hover */
    }

    .form-section h2 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        text-align: center;
    }

    .form-section p {
        margin-bottom: 20px;
        font-size: 1.2rem;
        text-align: center;
    }

    .form-group {
        width: 100%;
        max-width: 350px;
        /* Consistent width for form elements */
        margin-bottom: 20px;
    }

    .form-group input {
        width: 100%;
        padding: 15px;
        border: 1px solid #DDD;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group input:focus {
        border-color: #FFD700;
        box-shadow: 0 0 10px #FFD700;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 350px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    /* Log In Button */
    .login-btn {
        width: 100%;
        /* Full width for buttons */
        max-width: 350px;
        /* Consistent width */
        padding: 15px;
        background-color: #62825D;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        color: white;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        margin-bottom: 15px;
        /* Larger spacing for Log In button */
    }

    .login-btn:hover {
        background-color: #57724D;
        transform: scale(1.02);
    }

    /* Social Buttons */
    .social-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center align the buttons */
        gap: 15px;
        /* Increased gap to prevent misclicks */
        width: 100%;
        max-width: 350px;
    }

    .social-btn {
        width: 100%;
        padding: 15px;
        /* Consistent padding for all buttons */
        background-color: #62825D;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        color: white;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .social-btn:hover {
        background-color: #57724D;
        transform: scale(1.02);
    }

    .social-btn i {
        margin-right: 8px;
        color: white;
    }

    /* Divider */
    .divider {
        width: 100%;
        max-width: 350px;
        margin: 20px 0;
        text-align: center;
        font-size: 1rem;
        color: #888;
        position: relative;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background-color: #888;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    /* Success Message */
    #successMessage {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #074E45;
        padding: 50px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        color: white;
        opacity: 0;
        visibility: hidden;
        z-index: 1000;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    #successMessage h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    #successMessage p {
        font-size: 1.2rem;
    }

    /* Show success message */
    #successMessage.show {
        opacity: 1;
        visibility: visible;
    }

    /* Error Message */
    .error-message {
        color: #FF4D4D;
        font-size: 1rem;
        margin-top: -10px;
        margin-bottom: 20px;
        text-align: left;
    }

    /* Fading background effect */
    body.loading::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 500;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* Media Queries for responsiveness */
    @media (max-width: 768px) {
        .login-container {
            flex-direction: column;
        }

        .image-section {
            height: 300px;
        }

        .form-section {
            padding: 30px;
        }
    }

    @media (max-width: 480px) {
        .form-section h2 {
            font-size: 2rem;
        }

        .form-group input {
            font-size: 0.9rem;
        }
    }
</style>

<body>
    <main>
        <div class="login-container">
            <div class="image-section">
                <img src="{{ asset('images/login_background.jfif') }}" alt="Spa Relaxation">
            </div>
            <div class="form-section">
                <h2>Login to your Account</h2>
                <p>Welcome back!</p>
                <form id="loginForm" method="POST" action="{{ route('login.action') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="text-black" name="email" id="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                        <span class="text-red-500">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="text-black" name="password" id="password" placeholder="Enter your password" required>
                        @if ($errors->has('password'))
                        <span class="text-red-500">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-options">
                        <div class="forgot-password">
                            <a href="#">Forgot Password?</a>
                        </div>
                        <div class="remember-me">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">Log In</button>
                </form>
                <div class="divider">
                    <span>Or</span>
                </div>
                <div class="social-buttons">
                    <button class="social-btn">
                        <i class="fab fa-facebook"></i>
                        <a href="{{ route('auth.redirection', 'facebook') }}">Login with Facebook</a>
                    </button>

                    <button class="social-btn">
                        <i class="fab fa-google"></i>
                        <a href="{{ route('auth.redirection', 'google') }}">Login with Google</a>
                    </button>

                </div>
                <div class="register-link">
                    <p>Don't have an account? <a href="/register">Register here</a></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>