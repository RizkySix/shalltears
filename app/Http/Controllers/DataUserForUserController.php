<?php

namespace App\Http\Controllers;

use App\Models\SellingProduk;
use App\Models\User;
use Illuminate\Http\Request;

class DataUserForUserController extends Controller
{
    public function view_user()
    {
        $getUser = User::where('role' , '=' , 1306)->orderBy('star' , 'DESC')->paginate(50 , ['*'] , 'designer-contribute')->withQueryString();

        return $getUser;

    }

    public function produk_contribute()
    {
        $getProduk = SellingProduk::with(['category' , 'user'])->get();

        return $getProduk;
    }
}
