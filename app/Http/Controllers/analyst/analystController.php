<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class analystController extends Controller
{
    public function index()
    {
        return view('analyst.dashboard');
    }
}
