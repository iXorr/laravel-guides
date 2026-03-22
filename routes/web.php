<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationController;

Route::view('', 'index')->name('index');

Route::get('courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('applications', [ApplicationController::class, 'index'])
    ->name('applications.index');

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');
