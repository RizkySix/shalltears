<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CuttingProduk;
use App\Models\DesignPoint;
use App\Models\Diskon;
use App\Models\Order;
use App\Models\SellingProduk;
use App\Models\User;
use App\Models\UserKeranjang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class SellingProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->put('selling_arsip' , Route::currentRouteName());

        $produks = SellingProduk::where('status_arsip' , false)->with('cutting_produks')->latest()->paginate(10)->withQueryString();

        $diskons = Diskon::latest()->get();

        if($request->search){
            $produks = SellingProduk::orderByRaw("nama_produk like '%$request->search%' DESC")
                        ->where('status_arsip' , false)
                        ->with('cutting_produks')
                        ->latest()->paginate(10)->withQueryString();
        }

        return view('produks.selling_view' , [
            'title' => 'Produks Selling Page',
            'produks' =>  $produks,
            'diskons' =>  $diskons,
            'date_now' => Carbon::now()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        return view('produks.create_view' , [
            'title' => 'Produks Create Selling Page',
            'categories' => $category::latest()->get(),
            'cutting_produks' => CuttingProduk::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'nama_produk.min' => 'Isi nama produk minimal 8 karakter!.',
            'category_id.gt' => 'Category pakaian harus dipilih!.',
            'deskripsi_produk.min' => 'Deskripsi produk diisi minimal 15 karakter.',
            'warna_produk.min' => 'Masukan warna produk dengan benar.'
        );
        
        $rules = [
            'slug_id' => 'unique|string|min:5',
            'nama_produk' => 'required|string|min:5',
            'category_id' => 'required|integer|gt:0',
            'produk_image1' => 'required|image|file|max:5120',
            'produk_image2' => 'nullable|image|file|max:5120',
            'produk_image3' => 'nullable|image|file|max:5120',
            'produk_image4' => 'nullable|image|file|max:5120',
            'produk_image5' => 'nullable|image|file|max:5120',
            'produk_image6' => 'nullable|image|file|max:5120',
            'produk_image7' => 'nullable|image|file|max:5120',
            'produk_image8' => 'nullable|image|file|max:5120',
            'deskripsi_produk' => 'required|string|min:15',
            'warna_produk' => 'required|string|min:3',
            'harga_produk' => 'required|string',
           

        ];

        //berikan validasi required jika ada request id designer
        if($request->user_id){
            $rules['user_id'] = 'required|integer';
        }

        $validatedData = $request->validate($rules , $messages);

        //generate uuid
        $validatedData['slug_id'] = fake()->uuid();

        if(auth()->user()->role == 666){
            $validatedData['nama_admin'] = auth()->user()->nama;
        }

        //image1
        if($request->file('produk_image1')){
            $validatedData['produk_image1'] = $request->file('produk_image1')->store('produks_images');
        }
        //image2
        if($request->file('produk_image2')){
            $validatedData['produk_image2'] = $request->file('produk_image2')->store('produks_images');
        }
        //image3
        if($request->file('produk_image3')){
            $validatedData['produk_image3'] = $request->file('produk_image3')->store('produks_images');
        }
        //image4
        if($request->file('produk_image4')){
            $validatedData['produk_image4'] = $request->file('produk_image4')->store('produks_images');
        }
        //image5
        if($request->file('produk_image5')){
            $validatedData['produk_image5'] = $request->file('produk_image5')->store('produks_images');
        }
        //image6
        if($request->file('produk_image6')){
            $validatedData['produk_image6'] = $request->file('produk_image6')->store('produks_images');
        }
        //image7
        if($request->file('produk_image7')){
            $validatedData['produk_image7'] = $request->file('produk_image7')->store('produks_images');
        }
        //image8
        if($request->file('produk_image8')){
            $validatedData['produk_image8'] = $request->file('produk_image8')->store('produks_images');
        }

        $validatedData['harga_produk'] = str_replace('.' , '' , $validatedData['harga_produk']);
    
       if($request->user_id){
        $getRealUser = User::where('id' , $validatedData['user_id'])->get();
        if($getRealUser->count() == 0){
            return back()->with('success' , 'User yang didaftarkan tidak ada');
        }
        
        $up_star = User::where('id' , $validatedData['user_id'])->pluck('star');
        foreach($up_star as $star)
        {
            User::where('id' , $validatedData['user_id'])->update(['star' => $star += 1]);
        }
       }

        $validatedData['durasi_point'] = Carbon::now()->addMonths(2);

       $sellingProduk =  SellingProduk::create($validatedData);

       //membuat collection kemudian map untuk menyimpan data stok produk yang diambil dari variabel $cuttingProduks
       $cuttingProduk = collect($request->input('cutting' , []))->map(function($cuttingProduks){
            return ['stok_produk' => $cuttingProduks];
       });


       //input data id selling produk dan id cutting produk pada table pivot mereka (selling_produk_cutting_produk)
       $sellingProduk->cutting_produks()->sync($cuttingProduk);
        return redirect('/selling_produks')->with('success' , 'Produk baru berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SellingProduk  $sellingProduk
     * @return \Illuminate\Http\Response
     */
    public function show(SellingProduk $sellingProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SellingProduk  $sellingProduk
     * @return \Illuminate\Http\Response
     */
    public function edit(SellingProduk $sellingProduk)
    {
        
       
        $produk = SellingProduk::findOrFail($sellingProduk->id);
        $getPivot = $produk->cutting_produks()->where('selling_produks_id' , $sellingProduk->id)->pluck('cutting_produks_id');

        $produk_cutting = CuttingProduk::where('category_id' , $sellingProduk->category_id)->whereNotIn('id'  , $getPivot)->latest()->get();
      

        return view('produks.edit_view' , [
            'title' => 'Rubah Produk',
            'produk' => $sellingProduk,
            'categories' => Category::latest()->get(),
            'produk_cutting' => $produk_cutting,
            'cutting_produks' => CuttingProduk::latest()->get()
        ]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SellingProduk  $sellingProduk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellingProduk $sellingProduk)
    { 
        $messages = array(
            'nama_produk.min' => 'Isi nama produk minimal 8 karakter!.',
            'category_id.gt' => 'Category pakaian harus dipilih!.',
            'deskripsi_produk.min' => 'Deskripsi produk diisi minimal 15 karakter.',
            'warna_produk.min' => 'Masukan warna produk dengan benar.'
        );
        
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|min:5',
            'category_id' => 'required|integer|gt:0',
            'produk_image1' => 'nullable|image|file|max:5120',
            'produk_image2' => 'nullable|image|file|max:5120',
            'produk_image3' => 'nullable|image|file|max:5120',
            'produk_image4' => 'nullable|image|file|max:5120',
            'produk_image5' => 'nullable|image|file|max:5120',
            'produk_image6' => 'nullable|image|file|max:5120',
            'produk_image7' => 'nullable|image|file|max:5120',
            'produk_image8' => 'nullable|image|file|max:5120',
            'deskripsi_produk' => 'required|string|min:15',
            'warna_produk' => 'required|string|min:3',
            'harga_produk' => 'required|string',
            'user_id' => 'nullable|integer'
        ], $messages);



        //image1
        if($request->file('produk_image1')){
            if($sellingProduk->produk_image1){
                Storage::delete($sellingProduk->produk_image1);
            }
            $validatedData['produk_image1'] = $request->file('produk_image1')->store('produks_images');
        }
        //image2
        if($request->file('produk_image2')){
            if($sellingProduk->produk_image2){
                Storage::delete($sellingProduk->produk_image2);
            }
            $validatedData['produk_image2'] = $request->file('produk_image2')->store('produks_images');
        }
        //image3
        if($request->file('produk_image3')){
            if($sellingProduk->produk_image3){
                Storage::delete($sellingProduk->produk_image3);
            }
            $validatedData['produk_image3'] = $request->file('produk_image3')->store('produks_images');
        }
         //image4
         if($request->file('produk_image4')){
            if($sellingProduk->produk_image4){
                Storage::delete($sellingProduk->produk_image4);
            }
            $validatedData['produk_image4'] = $request->file('produk_image4')->store('produks_images');
        }
         //image5
         if($request->file('produk_image5')){
            if($sellingProduk->produk_image5){
                Storage::delete($sellingProduk->produk_image5);
            }
            $validatedData['produk_image5'] = $request->file('produk_image5')->store('produks_images');
        }
         //image6
         if($request->file('produk_image6')){
            if($sellingProduk->produk_image6){
                Storage::delete($sellingProduk->produk_image6);
            }
            $validatedData['produk_image6'] = $request->file('produk_image6')->store('produks_images');
        }
         //image7
         if($request->file('produk_image7')){
            if($sellingProduk->produk_image7){
                Storage::delete($sellingProduk->produk_image7);
            }
            $validatedData['produk_image7'] = $request->file('produk_image7')->store('produks_images');
        }
         //image8
         if($request->file('produk_image8')){
            if($sellingProduk->produk_image8){
                Storage::delete($sellingProduk->produk_image8);
            }
            $validatedData['produk_image8'] = $request->file('produk_image8')->store('produks_images');
        }

        $validatedData['harga_produk'] = str_replace('.' , '' , $validatedData['harga_produk']);

        SellingProduk::where('id' , $sellingProduk->id)->update($validatedData);


        $pivotSellProduct = SellingProduk::find($sellingProduk->id);

        //jika seandainya user ingin merubah category product maka hapus dulu seluruh data pada pivot untuk selling_produk_id terkait
        if($validatedData['category_id'] != $sellingProduk->category_id){
           $pivotSellProduct->cutting_produks()->wherePivot('selling_produks_id' , $sellingProduk->id)->detach();
        }

        //update table pivot 
        if($request->input('cutting' , [])){

        foreach($request->input('cutting' , []) as $cutt_id => $stok){
            $pivotRecord = $pivotSellProduct->cutting_produks()->wherePivot('cutting_produks_id' , $cutt_id);
            if($pivotRecord->exists()){ //bisa memakai exists atau count
                if($stok != null){
                    $pivotSellProduct->cutting_produks()->updateExistingPivot($cutt_id , ['stok_produk' => $stok]);
                }else{
                    $pivotRecord->detach($cutt_id);
                }
            }else{
                $pivotSellProduct->cutting_produks()->attach($cutt_id , ['stok_produk' => $stok]);
            }
         }
        }

         //redirect lokasi
       return $this->route_redir('Produk berhasil dirubah');
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SellingProduk  $sellingProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellingProduk $sellingProduk)
    {
        
        $getOrder = Order::where('selling_produk_id' , $sellingProduk->id)->where('status' , 'Dipesan')->orWhere('selling_produk_id' , $sellingProduk->id)->where('status' , 'Dikirim')->get();

        $getPointUser = DesignPoint::where('selling_produk_id' , $sellingProduk->id)->get();

        if($getOrder->count() || $getPointUser->count() || $sellingProduk->user_point >= 25000)
        {
            return back()->with('success' , 'Produk tidak bisa dihapus karena dalam status dipesan');
        }

        $pivotSellProduct = SellingProduk::findOrFail($sellingProduk->id);

        //delete semua size untuk selling_produks_id yang sama dengan $sellingProduk->id
        $pivotSellProduct->cutting_produks()->where('selling_produks_id' , $sellingProduk->id)->detach();

        //delete semua data pivot yang berhubungan pada model keranjang
        $findDatas = UserKeranjang::all();

        foreach($findDatas as $findData)
        {
         
          $godel = $findData->selling_produks()->wherePivot('selling_produks_id' , $sellingProduk->id)->detach();
          if($godel){
            UserKeranjang::destroy($findData->id);
          }

        }
       
        
        for($i = 1; $i <= 8; $i++){
            if($sellingProduk->{'produk_image' . $i}){ //memanggil attribut dengan dinamis
                Storage::delete($sellingProduk->{'produk_image' . $i});
            }
           }

        SellingProduk::destroy($sellingProduk->id);

        //redirect lokasi
       return $this->route_redir('Produk berhasil dihapus');
        
    }

    public function route_redir($pesan)
    {

        //function2 yang memanggil function ini , function destroy,update.
        if(session('selling_arsip') == 'selling_produks.index'){
            return redirect('/selling_produks')->with('success' , $pesan);
        }

        if(session('selling_arsip') == 'view_arsip'){
            return redirect('/arsip-product')->with('success' , $pesan);
        }
    }
}
