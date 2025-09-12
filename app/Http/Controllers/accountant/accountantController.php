<?php

namespace App\Http\Controllers\accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class accountantController extends Controller
{
    public function index()
    {
        return view('accountant.dashboard');
    }
}
