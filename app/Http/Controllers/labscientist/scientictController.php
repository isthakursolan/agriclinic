<?php

namespace App\Http\Controllers\labscientist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class scientictController extends Controller
{
    public function index()
    {
        return view('lab.dashboard');
    }
}
