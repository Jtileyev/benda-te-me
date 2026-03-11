<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LiveController extends Controller
{
    public function index(): View
    {
        return view('public.live');
    }
}
