<?php

namespace App\Http\Controllers\consultant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class consultantController extends Controller
{
    public function index()
    {
        return view('consultant.dashboard');
    }
}
