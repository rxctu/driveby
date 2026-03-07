<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function mentions(): View
    {
        return view('legal.mentions');
    }

    public function privacy(): View
    {
        return view('legal.privacy');
    }

    public function cgv(): View
    {
        return view('legal.cgv');
    }

    public function cookies(): View
    {
        return view('legal.cookies');
    }
}
