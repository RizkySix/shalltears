<?php

namespace App\Http\Controllers;

use App\Jobs\IndomaretSettlementJob;
use App\Models\Order;
use App\Models\SellingProduk;
use App\Observers\OrderObserver;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    //callback
    public function webhookHandler(Request $request)
{

   // Set your Merchant Server Key
  $servKey =  \Midtrans\Config::$serverKey = 'SB-Mid-server-ZIQN-OESa2DqSuWktHb9lGqW';
   // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
   \Midtrans\Config::$isProduction = false;
   // Set sanitization on (default)
   \Midtrans\Config::$isSanitized = true;
   // Set 3DS transaction for credit card to true
   \Midtrans\Config::$is3ds = true;
    /* $notif = new \Midtrans\Notification(); */

    $hash = hash('sha512' , $request->order_id . $request->status_code . $request->gross_amount . $servKey);
    if($hash == $request->signature_key){
        
        $getOrder = Order::where('order_id' , $request->order_id)->get();

        if($request->transaction_status == 'settlement' || $request->transaction_status == 'capture'){
            
          if($getOrder->count()){
            Order::where('order_id' , $request->order_id)->update(['transaction_status' => $request->transaction_status]);

            //call observer
            $getCurrentStatus = Order::where('order_id' , $request->order_id)->get();
            $orderObs = new OrderObserver;
            $orderObs->mass_updated($getCurrentStatus);
          }
            

            foreach($getOrder as $findProduk)
            {
                $getProduk = SellingProduk::find($findProduk->selling_produk_id);

                if($getProduk->durasi_point > Carbon::now()){
                    $persen = 25/100;
                    $total_normal = $getProduk->harga_produk * $findProduk->qty;
                    $amount = str_replace(',' , '' , number_format($total_normal));
                    $point = $amount * $persen;
                    $current_point = $getProduk->user_point + str_replace(',' , '' , number_format($point));
                   }else{
                    $current_point = $getProduk->user_point;
                   }

                //update
                SellingProduk::where('id' , $getProduk->id)->update(['terjual' => $getProduk->terjual += $findProduk->qty , 'user_point' => $current_point]);
            }
        }

        if($request->transaction_status == 'expire'){
            
            foreach($getOrder as $theOrder)
            {
                $getProduk  = SellingProduk::find($theOrder->selling_produk_id);
                foreach($getProduk->cutting_produks as $cut_prod){
                    if($cut_prod->cutting_name == $theOrder->size){
                        $getProduk->cutting_produks()->updateExistingPivot($cut_prod->pivot->cutting_produks_id , ['stok_produk' => $cut_prod->pivot->stok_produk += $theOrder->qty]);
                    }
                }

            }

            Order::where('order_id' , $request->order_id)->delete();
        }
    }


    
}

}
