<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::controller(AuthController::class)->group(function () 
{
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::post('logout', 'logout')->name('logout');

    Route::get('auth/redirection/{provider}', 'authProviderRedirect')->name('auth.redirection');
    Route::get('auth/{provider}/callback', 'socialAuthentication')->name('auth.callback');
});


Route::middleware(['auth', 'user'])->group(function () 
{
    Route::get('/home', [UserController::class, 'index'])->name('home');

    Route::get('/home/services-appointment', [UserController::class, 'spa_appointment'])->name('appointment.user');
    Route::post('/home/services-appointment/storeServices', [UserController::class, 'storeServices'])->name('services.save');
    Route::get('/home/services-appointment/appointmentDate', [UserController::class, 'appointmentDate'])->name('appointment.date');
    Route::get('/home/services-appointment/appointmentTime', [UserController::class, 'appointmentTime'])->name('appointment.time');

    Route::post('/home/services-appointment/storeDate', [UserController::class, 'storeDate'])->name('appointment.storeDate');

    

});