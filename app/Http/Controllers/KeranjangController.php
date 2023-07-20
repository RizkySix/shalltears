<?php

namespace App\Http\Controllers;

use App\Models\CuttingProduk;
use App\Models\Order;
use App\Models\SellingProduk;
use App\Models\User;
use App\Models\UserKeranjang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KeranjangController extends Controller
{

    public function keranjang_user(Request $request)
    {
        $keranjang = UserKeranjang::where('user_id' , auth()->user()->id)->with(['user'])->latest()->paginate(10)->withQueryString();
   
        return view('keranjang.user_keranjang' , [
            'title' => 'Keranjang Anda',
            'keranjangs' => $keranjang,

        ]);
    }

    public function confirmation_keranjang(Request $request)
    {
         session()->put('items' , $request->input('items'));
        $keranjang = UserKeranjang::where('user_id' , auth()->user()->id)->with(['user'])->latest()->get();

         // Set your Merchant Server Key
         \Midtrans\Config::$serverKey = 'SB-Mid-server-ZIQN-OESa2DqSuWktHb9lGqW';
         // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
         \Midtrans\Config::$isProduction = false;
         // Set sanitization on (default)
         \Midtrans\Config::$isSanitized = true;
         // Set 3DS transaction for credit card to true
         \Midtrans\Config::$is3ds = true;
        
         $phone = str_replace('-' , '' , $request->no_hp);
        
         $itemDetails = array();
         foreach(session('items') as $krjs) {
            $selected = UserKeranjang::where('id' , $krjs)->with(['user'])->latest()->get();
            foreach($selected as $krj)
            {
                foreach($krj->selling_produks as $produk) {
                    $real_harga = $produk->harga_produk;
                    if($produk->diskon_id && $produk->diskon->status_aktif == true){
                        $persenDiskon = $produk->diskon->persen_diskon/100;
                          $real_harga = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
                    }
                    $itemDetails[] = array(
                        "id" => "shalltears",
                        "price" => $real_harga,
                        "quantity" => $krj->qty,
                        "name" => $produk->nama_produk
                    );
                }
            }
         }
         
         $enable_payment = array(
            'indomaret',
            'bca_va',
            'bni_va',
            'bri_va',
        );

         $params = array(
             'transaction_details' => array(
                 'order_id' => rand(),
                 'gross_amount' => 10000,
             ),
             "item_details" => $itemDetails,
             'customer_details' => array(
                 'first_name' => $request->pemesan,
                 'last_name' => '',
                 'phone' => $phone,
                 "billing_address" => array(
                     "address" => $request->alamat,
                 ),
             ),
             'enabled_payments' => $enable_payment
            
         );
         

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('keranjang.confirmation' , [
            'title' => 'Konfirmasi Pesanan',
            'keranjangs' => $keranjang,
            'snapToken' => $snapToken,
        ]);
    }

    public function transaksi (Request $request)
    {
        $json = json_decode($request->get('json'));
        $arrJson = json_decode($request->get('json') , true);

         //jika metode pembayaran menggunakan indomaret
         if($json->payment_type == 'cstore'){
            $response = Http::withBasicAuth('SB-Mid-server-ZIQN-OESa2DqSuWktHb9lGqW' , '')->withHeaders([
                 'accept' => 'application/json'
             ])->get('https://api.sandbox.midtrans.com/v2/' . $json->order_id . '/status');
 
             $arrResponse = json_decode($response , true);
             if($arrResponse['status_code'] == '200' && $arrResponse['transaction_status'] == 'settlement'){
                 $json->transaction_status = $arrResponse['transaction_status'];
             }
          }

        foreach(session('items') as $krjs) {
            $selected = UserKeranjang::where('id' , $krjs)->with(['user'])->latest()->get();
            foreach($selected as $krj)
            {
                foreach($krj->selling_produks as $produk) {
                    $harga =  $produk->harga_produk * $krj->qty;

                    $real_harga = $produk->harga_produk;
                    if($produk->diskon_id && $produk->diskon->status_aktif == true){
                        $persenDiskon = $produk->diskon->persen_diskon/100;
                        $real_harga = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
                    }
                    $user_data  = [
                        'user_id' => auth()->user()->id,
                        'selling_produk_id' => $produk->id,
                        'status' => 'Dipesan',
                        'transaction_status' => $json->transaction_status,
                        'transaction_id' => $json->transaction_id,
                        'order_id' => $json->order_id,
                        'pemesan' => $request->pemesan,
                        'nama_produk' => $produk->nama_produk,
                        'warna' => $produk->warna_produk,
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'size' => $krj->cutting->cutting_name,
                        'qty' => $krj->qty,
                        'harga' => $real_harga,
                        'gross_amount' => $json->gross_amount,
                        'payment_type' => $json->payment_type,
                        
                       ];
                
                       if(isset($json->payment_code)){
                        $user_data['payment_code'] = $json->payment_code;
                        $user_data['via_payment'] = $json->payment_type;
                       }
                
                       if(isset($json->pdf_url)){
                        $user_data['pdf_url'] = $json->pdf_url;
                       }


                       if(isset($arrJson['va_numbers'])){
                        $bank = $arrJson['va_numbers'][0];
                        $user_data['payment_code'] = $bank['va_number'];
                        $user_data['via_payment'] = $bank['bank'];
                    }
            

                    //logic beri upah 25% kepada pemilik design
                    $getProduk = SellingProduk::where('id' , $produk->id)->get();
                    foreach($getProduk as $prdk)
                    {
                        if($prdk->durasi_point > Carbon::now()){
                            $persen = 25/100;
                            $amount = str_replace(',' , '' , number_format($harga));
                            $point = $amount * $persen;
                            $current_point = $prdk->user_point + str_replace(',' , '' , number_format($point));
                        }else{
                            $current_point = $prdk->user_point;
                        }
                             //update
                                if($json->transaction_status == 'settlement' || $json->transaction_status == 'capture')
                                {
                                    SellingProduk::where('id' , $produk->id)->update(['terjual' => $prdk->terjual += $krj->qty , 'user_point' => $current_point]);
                                }
                           
                        
                    }

                    //logic perbarui table pivot untuk jumlah stok produk
                    $pivotSellProduct = SellingProduk::find($produk->id);
                    $pivotRecord = $pivotSellProduct->cutting_produks()->wherePivot('selling_produks_id' , $produk->id)->wherePivot('cutting_produks_id' , $krj->cutting_produk_id)->get();
              
                    if($pivotRecord->count())
                    {
                        foreach($pivotRecord as $record)
                        {
                          
                        if($record->pivot->stok_produk != 0)
                        {
                            $current_stok = $record->pivot->stok_produk - $krj->qty;
                        
                        }else{
                            $current_stok = $record->pivot->stok_produk;
                        }
                        }
                        $pivotSellProduct->cutting_produks()->updateExistingPivot($krj->cutting_produk_id , ['stok_produk' => $current_stok]);
                    }
                    
                    Order::create($user_data);
                }
            }
            //Hapus keranjang jika berhasil checkout
            $findKeranjangPivot = UserKeranjang::find($krjs);
            $findKeranjangPivot->selling_produks()->wherePivot('keranjang_id' , $krjs)->detach();
            UserKeranjang::destroy($krjs);
         }

         return redirect('/checkouted-keranjang/' . $json->order_id);
    
    }



    public function checkout_keranjang($order_id)
    {
        
        $getOrder = Order::where('order_id', $order_id)->with('user')->latest()->get();
        return view('keranjang.done_order' , [
            'title' => 'Keranjang Checkout Berhasil',
            'orders' => $getOrder
        ]);
    }

    public function data_kerajang($qty_krj , $size_krj , $krj_prod_id)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'qty' => $qty_krj,
            'cutting_produk_id' => $size_krj
        ];
    $keranjang = UserKeranjang::create($data);
    $keranjang->selling_produks()->attach($krj_prod_id);
    }

    public function store(Request $request)
    {
       $keranjang = UserKeranjang::where('user_id' , auth()->user()->id)->with(['user'])->latest()->get();
      if($keranjang->count())
      {
        foreach($keranjang as $krj)
        {
         foreach($krj->selling_produks as $produk){
             if($produk->id == $request->keranjang_produk_id && $krj->cutting_produk_id == $request->size_keranjang){
                 UserKeranjang::where('id' , $krj->id)->update(['qty' => $krj->qty += $request->qty_keranjang]);
                 return back()->with('success' , 'Produk ditambahkan ke Keranjang');
             }
         }
        }
        $this->data_kerajang($request->qty_keranjang, $request->size_keranjang, $request->keranjang_produk_id);
        return back()->with('success' , 'Produk ditambahkan ke Keranjang');

      }else{
        $this->data_kerajang($request->qty_keranjang, $request->size_keranjang, $request->keranjang_produk_id);
        return back()->with('success' , 'Produk ditambahkan ke Keranjang');
      }

    }


    public function update(UserKeranjang $keranjang , Request $request)
    {
        UserKeranjang::where('id' , $keranjang->id)->update(['cutting_produk_id' => $request->size_keranjang , 'qty' => $request->qty_keranjang]);
        return back()->with('success' , 'Berhasil memperbaharui');
    }


    public function delete(UserKeranjang $keranjang , Request $request)
    {
        $findData = UserKeranjang::find($keranjang->id);

        $findData->selling_produks()->wherePivot('keranjang_id' , $keranjang->id)->detach();
        UserKeranjang::destroy($keranjang->id);
        return back()->with('success' , 'Produk dihapus dari keranjang');
    }
}
