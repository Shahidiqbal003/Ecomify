<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperFrontendController extends Controller
{
    public function index()
    {
        return view('super_ui.index');
    }
}
