<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
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
                return redirect()->route('manager.home');

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
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user,manager',
        ]);

        // Save the user in the database
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'birth_date' => $validatedData['birth_date'],
            'mobile_number' => $validatedData['mobile_number'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);


        // Redirect with success message

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
}
