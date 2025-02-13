<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has a role of 'user'
        if (Auth::check() && Auth::user()->role == 'user') {
            return $next($request); // Allow the request to proceed
        }

        // Redirect if the user is not of role 'user'
        return redirect()->route('admin.home')->withErrors('You do not have access to this resource.');
    }
}



