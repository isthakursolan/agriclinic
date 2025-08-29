<?php

namespace App\Http\Controllers\fieldAgent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class fielfagentController extends Controller
{
    public function index()
    {
        return view('agent.dashboard');
    }
}
