<?php

namespace App\Http\Controllers;

use App\Mail\MailOrderSend;
use App\Mail\MailPointCair;
use App\Models\DesignPoint;
use App\Models\Order;
use App\Models\User;
use App\Observers\OrderObserver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminWorkController extends Controller
{
    public function dipesan()
    {
        $getOrder = Order::where('status' , 'Dipesan')->with(['user'])->latest()->get();
        return view('admin.dipesan' , [
            'title' => 'Pesanan dipesan',
            'orders' => $getOrder
        ]);
    }

    public function dikirim()
    {
        $getOrder = Order::where('status' , 'Dikirim')->with(['user'])->latest()->get();
        return view('admin.dikirim' , [
            'title' => 'Pesanan dikirim',
            'orders' => $getOrder
        ]);
    }

    public function selesai()
    {
        $getOrder = Order::where('status' , 'Selesai')->with(['user'])->latest()->get();
        return view('admin.selesai' , [
            'title' => 'Pesanan selesai',
            'orders' => $getOrder
        ]);
    }

    public function update(Order $order , Request $request)
    {
        if($request->jne_resi)
        {
            $validatedData = $request->validate([
                'jne_resi' => 'required|string'
            ]);

            $getUser = User::where('id' , $order->user_id)->pluck('nama' , 'email');
            foreach($getUser as $email => $nama){}

            $getAllSameOrders = Order::where('order_id' , $order->order_id)->with(['user' , 'selling_produk'])->get();

            $text = [
                'subject' => 'Pesanan dikirim ID (' . $order->order_id . ')',
                'pesanan_dikirim' => 'Pesanan kamu dalam proses pengiriman',
                'nama' => $nama,
                'orders' => $getAllSameOrders,
                'kode_jne' => $validatedData['jne_resi']

            ];

            try {
                //kirim email ke pemesan...
                Mail::to($email)->send(new MailOrderSend($text));
            } catch (\Throwable $th) {
                return back();
            }

            Order::where('order_id' , $order->order_id)->update(['status' => 'Dikirim' , 'jne_resi' => $validatedData['jne_resi']]);
            return back()->with('success' , 'Produk dikirim');
        }


        if($request->user_done)
        {
          Order::where('order_id' , $order->order_id)->update(['status' => 'Selesai']);
       
            return back()->with('success' , 'Produk dikonfirmasi selesai');
        }


    }


    public function bayar_point()
    {
        $getPoint = DesignPoint::where('status' , 'pending')->latest()->with(['user' , 'selling_produk'])->paginate(10)->withQueryString();
        return view('admin.point' , [
            'title' => 'Penarikan point designer',
            'points' => $getPoint
        ]);
    }

    public function point_cair($user_id , Request $request)
    {
        if($request->file('bukti_tf')){
            $bukti_tf = $request->file('bukti_tf')->store('bukti-transfer');
        }

        $getUser = User::where('id' , $user_id)->get();
        foreach($getUser as $user){}
        $text = [
            'subject' => 'Designer Point to Money',
            'point_cair' => 'Point anda sudah dicairkan',
            'nama' => $user->nama,
            'nama_rekening' => $request->nama_rekening,
            'no_rekening' => $request->no_rekening,
            'no_hp' => '087762582176',
            'bukti_tf' => asset('storage/' . $bukti_tf),
            'total_point' => $request->total_point
        ];

        try{

            //mengirim email ke penerima
            Mail::to($user->email)->send(new MailPointCair($text));
            }catch(Exception $th){
               return back();
            }
            
            DesignPoint::where('user_id' , $user_id)->delete();
            return back()->with('success' , 'Berhasil konfirmasi pencairan point');
            
    }

}
