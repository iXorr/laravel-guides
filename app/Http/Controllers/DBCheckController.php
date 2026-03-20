<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;     // подключайте модель вручную
use App\Models\UserRole; // подключайте модель вручную

class DBCheckController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        dump($users->toArray());

        $user = User::where('login', 'Admin')->first();
        dump($user->first_name, $user->role->title);
    }
}
