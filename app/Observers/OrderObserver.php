<?php

namespace App\Observers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
       
        if($order->status == 'Dipesan'){
            if($order->transaction_status == 'settlement' || $order->transaction_status == 'capture'){
                $gross_amount = $order->qty * $order->harga;

                DB::table('transaction_records')->insert([
                    'transaction_status' => $order->transaction_status,
                    'nama_produk' => $order->nama_produk,
                    'qty' => $order->qty,
                    'harga_satuan' => $order->harga,
                    'harga_total' => $gross_amount,
                    'tanggal_pembelian' => Carbon::now()
                ]);
            }
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
       
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function mass_updated($orders)
    {
        foreach($orders as $order){
            if($order->status == 'Dipesan'){
                if($order->transaction_status == 'settlement' || $order->transaction_status == 'capture'){
                    $gross_amount = $order->qty * $order->harga;

                    DB::table('transaction_records')->insert([
                        'transaction_status' => $order->transaction_status,
                        'nama_produk' => $order->nama_produk,
                        'qty' => $order->qty,
                        'harga_satuan' => $order->harga,
                        'harga_total' => $gross_amount,
                        'tanggal_pembelian' => Carbon::now()
                    ]);
                }
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
