<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        return view('applications.index', [
            'applications' => Application::all()
        ]);
    }
}
