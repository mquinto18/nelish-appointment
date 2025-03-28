<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayMongoController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::post('logout', 'logout')->name('logout');

    Route::get('auth/redirection/{provider}', 'authProviderRedirect')->name('auth.redirection');
    Route::get('auth/{provider}/callback', 'socialAuthentication')->name('auth.callback');
});


Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');

    Route::get('/home/services-appointment', [UserController::class, 'spa_appointment'])->name('appointment.user');
    Route::post('/home/services-appointment/storeServices', [UserController::class, 'storeServices'])->name('services.save');
    Route::get('/home/services-appointment/appointmentDate', [UserController::class, 'appointmentDate'])->name('appointment.date');
    Route::get('/home/services-appointment/appointmentTime', [UserController::class, 'appointmentTime'])->name('appointment.time');
    Route::get('/home/services-appointment/appointmentConfirm', [UserController::class, 'appointmentConfirm'])->name('appointment.appointment_confirm');

    Route::post('/home/services-appointment/storeDate', [UserController::class, 'storeDate'])->name('appointment.storeDate');
    Route::post('/home/services-appointment/storeTime', [UserController::class, 'storeTime'])->name('appointment.timeStore');
    Route::post('/home/services-appointment/confirmStore', [UserController::class, 'confirmStore'])->name('appointment.ConfirmStore');

    Route::post('/paymongo/gcash', [PayMongoController::class, 'gcashPayment'])->name('paymongo.gcash');
    Route::post('/paymongo/bank', [PayMongoController::class, 'bankPayment'])->name('paymongo.bank');
    Route::post('/services/cancel', [UserController::class, 'appointmentCancel'])->name('appointment.cancel');

    Route::get('/payment/success', [PayMongoController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failed', [PayMongoController::class, 'paymentFailed'])->name('payment.failed');
    Route::get('/home/accountSettings', [UserController::class, 'accountSettings'])->name('account.settings');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'password'])->name('account.password');
    Route::get('/booked-appointment', [AccountController::class, 'bookedAppointment'])->name('booked.appointments');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/clientTherapist', [AdminController::class, 'clientTherapist'])->name('clientTherapist.data');
    Route::get('/Appointment', [AdminController::class, 'viewAppointment'])->name('viewAppointment');
    Route::get('/therapistSched', [AdminController::class, 'therapistSched'])->name('therapistSched');
    Route::post('/admin/approve/{email}', [AdminController::class, 'approveAdmin'])->name('approve.admin');
    Route::post('/admin/reject/{email}', [AdminController::class, 'rejectAdmin'])->name('reject.admin');
    Route::post('/admin/updateStatus/{id}', [AdminController::class, 'updateStatus'])->name('update.appointment.status');
    Route::get('/admin/apppointments/edit/{id}', [AdminController::class, 'appointmentEdit'])->name('appointments.edit');
    Route::put('/admin/appointments/{appointment}', [AdminController::class, 'appointmentUpdate'])->name('appointments.update');
    Route::delete('/appointment/{id}', [AdminController::class, 'destroy'])->name('appointment.delete');
    Route::get('/dtrView/{therapist}/{weekOffset?}', [AdminController::class, 'dtrView'])->name('dtr.view');
    Route::get('/admin/systemUser', [AdminController::class, 'systemuser'])->name('systemUser');
    Route::post('/admin/saveUser', [AdminController::class, 'saveUser'])->name('save.user');
    
   
});

Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.home');
    Route::get('/dailyTimeRecord', [TherapistController::class, 'dailyRecord'])->name('dailyTimeRecord');
    Route::post('/dailyTimeRecord', [TherapistController::class, 'therapistDtr'])->name('therapist.dtr');
});
