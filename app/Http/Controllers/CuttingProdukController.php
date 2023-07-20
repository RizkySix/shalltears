<?php

namespace App\Http\Controllers;

use App\Models\CuttingProduk;
use App\Models\SellingProduk;
use Illuminate\Http\Request;

class CuttingProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        session()->flash('create_cutting' , $request->category_id);
        $validatedData = $request->validate([
            'category_id' =>  'required|integer' , 
            'cutting_name' => 'required|string'
        ]);

        $validatedData['cutting_name'] = strtoupper($validatedData['cutting_name']);
        $getSimiliarSize = CuttingProduk::where('category_id' , $validatedData['category_id'])
                                        ->where('cutting_name' , $validatedData['cutting_name'])
                                        ->get();

        //cek apakah ada data yabg sama jika ada buat session dan jangan buat size baru
        if(!$getSimiliarSize->isEmpty()){
            session()->flash('similiarSize' , $validatedData['cutting_name']);
            return back();
        }

        CuttingProduk::create($validatedData);
        return back()->with('success' , 'Size pakaian berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CuttingProduk  $cuttingProduk
     * @return \Illuminate\Http\Response
     */
    public function show(CuttingProduk $cuttingProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CuttingProduk  $cuttingProduk
     * @return \Illuminate\Http\Response
     */
    public function edit(CuttingProduk $cuttingProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CuttingProduk  $cuttingProduk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CuttingProduk $cuttingProduk)
    {
       
        session()->flash('update_cutting' , true);
        $validatedData = $request->validate([
            'cutting_name' => 'required|string',
        ]);

        $validatedData['cutting_name'] = strtoupper($validatedData['cutting_name']);
        
        //cek apakah value cutting sudah ada atau belom
        $getSimiliarSize = CuttingProduk::where('category_id' , $cuttingProduk->category_id)
        ->where('cutting_name' , $validatedData['cutting_name'])
        ->get();

        $valueSession = [
            'messages' => $validatedData['cutting_name'],
            'id_session' => $cuttingProduk->category_id
        ];

        if(!$getSimiliarSize->isEmpty()){
            session()->flash('same' , $valueSession);
            return back();
        }

        CuttingProduk::where('category_id' , $cuttingProduk->category_id)->where('cutting_name' , $request->old_cutting_name)->update($validatedData);
        return back()->with('success' , 'Size berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CuttingProduk  $cuttingProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(CuttingProduk $cuttingProduk)
    {
        session()->flash('update_cutting' , true);
        $cuttingID = $cuttingProduk->id;

        //cari relasi yang bernama cutting_produks pada model SellingProduk, kemudian jika ada cari column cutting_produks_id pada pivot yang nilai nya sama dengan $cuttingID
        $sellingProduk = SellingProduk::whereHas('cutting_produks' , function($data) use ($cuttingID) {
            $data->where('cutting_produks_id' , $cuttingID);
        })->get();

       
        //$sellingProduk berupa array diforeach, kemudian pada $selling atau model SellingProduk yang memiliki relasi cutting_produks mencari column cutting_produks_id pada table pivot yang nilainya sama dengan $cuttingId kemudian detach() atau delete data dari column cutting_produks_id yang nilainya sama dengan $cuttingID pd table pivot.
        
        foreach($sellingProduk as $selling){
            $selling->cutting_produks()->where('cutting_produks_id' , $cuttingID)->detach($cuttingID);

        }

       
        CuttingProduk::destroy($cuttingProduk->id);

        session()->flash('success' , 'Size berhasil dihapus');
    }
}
