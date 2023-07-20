<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HoldingDesignerController extends Controller
{
    public function view() {
        return view('auth.designHold');
    }
}
