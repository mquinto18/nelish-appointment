<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authProviderRedirect($provider)
    {
        if ($provider) {
            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }

    public function socialAuthentication($provider)
    {
        try {

            if ($provider) {
                $socialUser = Socialite::driver($provider)->user();
                
                // Check if user exists by Google ID or email
                $user = User::where('auth_provider_id', $socialUser->id)
                    ->orWhere('email', $socialUser->email)
                    ->first();

                if ($user) {
                    Auth::login($user);
                } else {
                    $userData = User::create([
                        'first_name' => $socialUser->name,
                        'email' => $socialUser->email,
                        'role' => 'user',
                        'auth_provider_id' => $socialUser->id,
                        'auth_provider' => $provider,
                        'password' => Hash::make('password'), // Secure random password
                    ]);

                    


                    if ($userData) {
                        Auth::login($userData);
                        return redirect()->route('home');
                    }
                }

                return redirect()->route('home');

            }
            abort(404);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function loginAction(Request $request)
    {
        // Validate the incoming request
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        // Attempt to log the user in with the provided credentials and remember me option
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // If authentication fails, throw a validation exception
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // This error message is provided by Laravel's authentication system
            ]);
        }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect based on the user role
        switch (auth()->user()->role) {
            case 'admin': // If role is admin
                return redirect()->route('admin.home');

            case 'manager': // If role is manager
                return redirect()->route('therapist.home');

            case 'user': // If role is user
                return redirect()->route('home');

            default:
                // If no role is matched
                return redirect()->route('home');
        }
    }
    public function register()
    {
        return view('auth.register');
    }

    public function registerSave(Request $request)
{
    // Validate input fields
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'birth_date' => 'required|date',
        'mobile_number' => 'required|digits:10',
        'gender' => 'required|in:male,female,other',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Set the role to 'user' automatically
    $role = 'user';

    // Save the user with 'user' role
    User::create([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'birth_date' => $validatedData['birth_date'],
        'mobile_number' => $validatedData['mobile_number'],
        'gender' => $validatedData['gender'],
        'password' => Hash::make($validatedData['password']),
        'role' => $role,  // Always 'user'
    ]);

    return redirect()->route('login')->with('success', 'Registration successful.');
}

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page (or wherever you'd like)
        return redirect('/login');
    }
    public function forgotPassword(){
        return view('adminComponents.forgotPassword');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Password::getRepository()->create($user); 

        $resetUrl = url('/reset-password/' . $token . '?email=' . $request->email);

        // Send email
        Mail::to($request->email)->send(new ForgotPasswordMail($resetUrl));

        return back()->with('success', 'Email sent successfully!');
    }
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Your password has been reset.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
