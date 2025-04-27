<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/customers', function () {
    return view('customers.index'); 
})->name('customers.index');


Route::get('/login', function () {
return view('auth.login'); 
})->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/city/{state_id}', [RegisterController::class, 'getCities'])->name('getCities');
Route::post('store',[UserController::class,'store'])->name('store');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');