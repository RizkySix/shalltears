<?php

namespace App\Http\Controllers;

use App\Models\DesignPoint;
use App\Models\SellingProduk;
use Illuminate\Http\Request;

class DesignPointController extends Controller
{
    public function cair(Request $request)
    {
        $getPoint = DesignPoint::where('selling_produk_id' , $request->selling_produk_id)->with(['selling_produk' , 'user'])->pluck('point_request');
        $getProduk = SellingProduk::where('id' , $request->selling_produk_id)->pluck('user_point');
        
        $messages = [
            'point_request.min' => 'Minimal penarikan sebesar 25000 point',
            'point_request.max' => 'Maximal penarikan sebesar ' . $request->max_point . ' point'
        ];

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'selling_produk_id' => 'required|integer',
            'point_request' => 'required|numeric|min:25000|max:' . $request->max_point,
            'nama_rekening' => 'required|min:3',
            'no_rekening' => 'required|min:9',
        ] , $messages);

        SellingProduk::where('id' , $request->selling_produk_id)->update(['user_point' => $getProduk[0] -= $validatedData['point_request']]);

        if($getPoint->count())
        {
            DesignPoint::where('selling_produk_id' , $request->selling_produk_id)->update(['point_request' => $getPoint[0] += $validatedData['point_request']]);
            return back()->with('success' , 'Permintaan penarikan point berhasil');
        }

        DesignPoint::create($validatedData);
        return back()->with('success' , 'Permintaan penarikan point berhasil');
    }
}
