<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserRole;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'exists:users,login'],
            'password' => ['required']
        ]);

        $user = User::where('login', $data['login'])->first();

        if ($user->password !== $data['password'])
            return back()
                ->withErrors([
                    'login' => 'Wrong data'
                ]);

        Auth::login($user);

        return redirect()
            ->route('index')
            ->with('message', 'You logged in!');
    }

    public function showRegisterForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'unique:users,login', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'alpha_dash', 'min:6', 'max:255'],
            'first_name' => ['required', 'min:3', 'max:255', 'regex:/[а-яёА-ЯЁ\\-\\s]/'],
            'last_name' => ['required', 'min:3', 'max:255', 'regex:/[а-яёА-ЯЁ\\-\\s]/'],
            'middle_name' => ['required', 'min:3', 'max:255', 'regex:/[а-яёА-ЯЁ\\-\\s]/'],
            'phone' => ['required', 'regex:/8\\(\\d{3}\\)\\d{3}-\\d{2}-\\d{2}/']
        ]);

        $data['user_role_id'] = UserRole::where('title', 'client')->first()->id;

        $user = User::create($data);

        return redirect()
            ->route('login')
            ->with('message', 'You registered!');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        Auth::logout($user);

        return redirect()
            ->route('index')
            ->with('message', 'You logged out!');
    }
}
