<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DBCheckController; // сами подключите контроллер

Route::get('/', [DBCheckController::class, 'index']);
