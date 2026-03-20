<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // подключите этот фасад вручную

class DBCheckController extends Controller
{
    public function index(Request $request)
    {
        dd(DB::connection()->getPdo());
    }
}
