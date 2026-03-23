<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationController;

Route::view('', 'index')->name('index');

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::get('register', [AuthController::class, 'showRegisterForm']);
Route::post('register', [AuthController::class, 'register'])
    ->name('register');

Route::middleware('auth')->group(function() {
    Route::resource('courses', CourseController::class);
    Route::resource('applications', CourseController::class);

    Route::get('logout', [AuthController::class, 'logout'])
        ->name('logout');
});
