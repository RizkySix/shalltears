<?php

namespace App\Http\Controllers;

use App\Models\SellingProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SellingProductArsipController extends Controller
{
    public function arsipkan($slug_id , $status)
    {
        if($status == "arsip"){
            SellingProduk::where('slug_id' , $slug_id)->update(['status_arsip' => true]);
            return back()->with('success' , 'Produk diarsipkan');
        }
        if($status == "publish"){
            SellingProduk::where('slug_id' , $slug_id)->update(['status_arsip' => false]);
            return back()->with('success' , 'Produk dipublish');
        }
    }


    public function arsip_product(Request $request)
    {
                
        session()->put('selling_arsip' , Route::currentRouteName());
        $produks = SellingProduk::where('status_arsip' , true)->with('cutting_produks')->latest()->paginate(10)->withQueryString();

        if($request->search){
            $produks = SellingProduk::orderByRaw("nama_produk like '%$request->search%' DESC")
                                ->where('status_arsip' , true)
                                ->with('cutting_produks')
                                ->latest()->paginate(10)->withQueryString();

        }
        return view('produks.arsip.view_arsip' , [
            'title' => 'Produk Diarsipkan',
            'produks' => $produks
        ]);
    }
}
