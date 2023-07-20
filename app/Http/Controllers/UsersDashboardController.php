<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SellingProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersDashboardController extends Controller
{
    public function user_dashboard()
    {
        
        return view('user_dashboard' , [
                'title' => 'User Dashboard'
        ]);
    }
}
