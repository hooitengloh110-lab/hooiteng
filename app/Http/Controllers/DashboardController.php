<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Primes;
use App\Models\Fibonacci;

class DashboardController extends Controller
{
    public function anyIndexPage(Request $request) {

        return view('index');
    }
}
