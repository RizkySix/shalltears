<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CuttingProduk;
use App\Models\Diskon;
use App\Models\Order;
use App\Models\SellingProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Js;

class UserViewProductController extends Controller
{
    public function view_produk(Request $request)
    {

     
        $categories = Category::latest()->get();
        $sell_produk = SellingProduk::where('status_arsip' , false)
                                    ->with(['category' , 'user'])
                                    ->latest()->paginate(10)->withQueryString();
        
        if($request->search)
        {
            $sell_produk = SellingProduk::orderByRaw("nama_produk like '%$request->search%' DESC")
                                    ->where('status_arsip' , false)
                                    ->with(['category' , 'user'])
                                    ->latest()->paginate(10)->withQueryString();
        }

        if($request->filter_category)
        {
            $sell_produk = SellingProduk::where('status_arsip' , false)
                                        ->where('category_id' , $request->filter_category)
                                        ->with(['category' , 'user'])
                                        ->latest()->paginate(10)->withQueryString();
        }

        if($request->terlaris){
            $sell_produk = SellingProduk::where('status_arsip' , false)
            ->with(['category' , 'user'])
            ->orderBy('terjual' , 'DESC')
            ->paginate(10)->withQueryString();
        }

        if($request->diskon){
            $sell_produk = SellingProduk::where('diskon_id' , '!=' , null)
            ->whereHas('diskon' , function($query){
                $query->where('status_aktif' , true);
            })
            ->with(['category' , 'user'])
            ->orderBy('terjual' , 'DESC')
            ->paginate(10)->withQueryString();
        }


        return view('produks.user_view' , [
            'title' => 'Shalltears Product',
            'produks' => $sell_produk,
            'categories' => $categories
        ]);
    }

    public function show_produk(Request $request)
    {
         // Set your Merchant Server Key
         \Midtrans\Config::$serverKey = 'SB-Mid-server-ZIQN-OESa2DqSuWktHb9lGqW';
         // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
         \Midtrans\Config::$isProduction = false;
         // Set sanitization on (default)
         \Midtrans\Config::$isSanitized = true;
         // Set 3DS transaction for credit card to true
         \Midtrans\Config::$is3ds = true;
    
         $phone = str_replace('-' , '' , $request->no_hp);
        
         $getRealProduk = SellingProduk::where('id' , $request->produk_id)->get();
         foreach($getRealProduk as $produk){
            $harga = $produk->harga_produk;
            if($produk->diskon_id && $produk->diskon->status_aktif == true && $produk->diskon->status_aktif == true){
                $persenDiskon = $produk->diskon->persen_diskon/100;
                $harga = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
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
            "item_details" => array(
                [
                  "id" => "shalltears",
                  "price" => $harga,
                  "quantity" => $request->qty,
                  "name" => $request->nama_produk,
                ],
                ),

            'customer_details' => array(
                'first_name' => $request->pemesan,
                'last_name' => '',
               /*  'email' => 'budi.pra@example.com', */
                'phone' => $phone,
                "billing_address" => array(
                   
                    "address" => $request->alamat,
                  
                ),
            ),

            "enabled_payments" => $enable_payment
            /* 'shipping_address' => array(
                "first_name" => "Budi",
                "last_name" => "Susanto",
                "email" => "budisusanto@example.com",
                "phone" => "0812345678910",
                "address" => "Sudirman",
                "city" => "Jakarta",
                "postal_code" => "12190",
                "country_code" => "IDN"
            ) */
        );
      
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $getSize = CuttingProduk::where('id' , $request->cutting_id)->pluck('cutting_name');
        foreach($getSize as $size){};
        return view('produks.show_produk' , [
            'title' => 'Shalltears Product',
            'snapToken' => $snapToken,
            'size' => $size,
            'harga' => $harga,
           
        ]);
    }

    public function transaksi(Request $request)
    {
       $json = json_decode($request->get('json'));
       $arrJson = json_decode($request->get('json'), true);
      

       $getSize = CuttingProduk::where('id' , $request->cutting_id)->pluck('cutting_name');
       foreach($getSize as $size){};

       $getRealProduk = SellingProduk::where('id' , $request->produk_id)->get();
         foreach($getRealProduk as $produk){
            $harga = $produk->harga_produk;
            if($produk->diskon_id && $produk->diskon->status_aktif == true){
                $persenDiskon = $produk->diskon->persen_diskon/100;
                $harga = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
            }

            $harga_normal = $produk->harga_produk;
         }

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

       $user_data  = [
        'user_id' => auth()->user()->id,
        'selling_produk_id' => $request->produk_id,
        'status' => 'Dipesan',
        'transaction_status' => $json->transaction_status,
        'transaction_id' => $json->transaction_id,
        'order_id' => $json->order_id,
        'pemesan' => $request->pemesan,
        'nama_produk' => $request->nama_produk,
        'warna' => $request->warna,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'size' => $size,
        'qty' => $request->qty,
        'harga' => $harga,
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


       //logic memberikan upah sebesar 25% kepada user yang memiliki design ini
       $getProduk = SellingProduk::where('id' , $request->produk_id)->get();
       foreach($getProduk as $produk)
       {
           if($produk->durasi_point > Carbon::now()){
            $persen = 25/100;
            $total_normal = $harga_normal * $request->qty;
            $amount = str_replace(',' , '' , number_format($total_normal));
            $point = $amount * $persen;
            $current_point = $produk->user_point + str_replace(',' , '' , number_format($point));
           }else{
            $current_point = $produk->user_point;
           }

            //update
            if($json->transaction_status == 'settlement' || $json->transaction_status == 'capture')
            {
                SellingProduk::where('id' , $request->produk_id)->update(['terjual' => $produk->terjual += $request->qty , 'user_point' => $current_point]);
            }
       }

       $pivotSellProduct = SellingProduk::find($request->produk_id);
       $pivotRecord = $pivotSellProduct->cutting_produks()->wherePivot('selling_produks_id' , $request->produk_id)->wherePivot('cutting_produks_id' , $request->cutting_id)->get();

       if($pivotRecord->count())
       {
        foreach($pivotRecord as $record)
        {
          if($record->pivot->stok_produk != 0)
          {
            $current_stok = $record->pivot->stok_produk - $request->qty;
          }else{
            $current_stok = $record->pivot->stok_produk;
          }
        }
        $pivotSellProduct->cutting_produks()->updateExistingPivot($request->cutting_id , ['stok_produk' => $current_stok]);
       }

       Order::create($user_data);
       return redirect('/information_order/' . $json->order_id)->with('success' , 'Berhasil Order');
    }


    public function done_order(Order $order)
    {
        return view('produks.done_order' , [
            'title' => 'Shalltears Information Transaction',
           'order' => $order
           
        ]);
    }



    public function riwayat_order(Request $request)
    {
        $orders = Order::where('user_id' , auth()->user()->id)->with('user')->latest()->get();

        if($request->search)
        {
            $orders =  Order::orderByRaw("order_id like '%$request->search%' DESC")->where('user_id' , auth()->user()->id)->with('user')->latest()->paginate(10)->withQueryString(); 
        }
        return view('produks.user_orders' , [
            'title' => 'Orders History',
           'orders' => $orders,
           'proses_ord' => Order::where('user_id' , auth()->user()->id)->where('status' , 'Dipesan')->orWhere('status' , 'Dikirim')->where('user_id' , auth()->user()->id)->count(),
           'selesai_ord' => Order::where('user_id' , auth()->user()->id)->where('status' , 'Selesai')->count(),
           
        ]);
    }
}
