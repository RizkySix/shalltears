<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DataForNavbarController extends Controller
{
    public function get_route_name()
    {
        
     return Route::currentRouteName();

    }
}
