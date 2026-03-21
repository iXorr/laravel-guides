<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Фасад авторизации

use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'exists:users,login'],
            'password' => ['required']
        ]);

        $user = User::where('login', 'Admin')->first();

        if ($user->password !== $data['password'])
            return back()
                ->withErrors([
                    'login' => 'Wrong data'
                ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        Auth::logout($user);

        return 'logged out';
    }
}
