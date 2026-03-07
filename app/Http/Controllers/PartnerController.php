<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::active()->sorted()->get();

        $types = $partners->groupBy('type');

        return view('partners.index', compact('partners', 'types'));
    }
}
