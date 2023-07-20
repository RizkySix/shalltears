<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\CuttingProduk;
use App\Models\Order;
use App\Models\User;
use App\Models\Voting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function admin_dashboard(Request $request)
    {
        $announcement = Announcement::latest();
        $voting = Voting::latest();

        if($request->search_pengumuman){
         $announcement = Announcement::where('judul' , 'like' , '%' . $request->search_pengumuman . '%')
                                    ->orWhere('pesan' , 'like' , '%' . $request->search_pengumuman . '%')
                                ->latest();
        }
        if($request->search_voting){
         $voting = Voting::where('judul_voting' , 'like' , '%' . $request->search_voting . '%')
                            ->orWhere('pesan_voting' , 'like' , '%' . $request->search_voting . '%')        
                        ->latest();
        }

        //query data untuk create voting berdasarkan id pengumuman
        $selected_announcement = Announcement::where('slug_id' , $request->announcement_id)->get();//untuk create voting
        $update_announcement = Announcement::where('slug_id' , $request->update_announcement)->get();
        $update_voting = Voting::where('slug_id' , $request->voting_update)->get();
        $update_category = Category::where('id', $request->categories_update)->get();
 
        $customer = User::where('role' , 1201)->get();
        $designer = User::where('role' , 1306)->where('approve' , true)->get();
        $unapprove_designer = User::where('role' , 1306)->where('approve' , false)->where('email_verified_at' , '!=' , null)->get();

        $setDayMorning = Carbon::now()->setTime('00' , '00' , '01');
        $setDayNight = Carbon::now()->setTime('23' , '59' , '59');
        $produk_terjual_harian = Order::whereBetween('created_at' , [$setDayMorning , $setDayNight])->where('transaction_status' , 'settlement')->with(['user' , 'selling_produk'])->get();

        //menampilkan transaction records
        $rowRecords = null;
        $sumHarga = 0;
        if($request->tanggal_mulai || $request->tanggal_selesai){

            $rule = [
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
               ];
        
               $validatedData = $request->validate($rule);
        
               $records = DB::table('transaction_records')->when(!$request->tanggal_selesai , function($query) use($validatedData) {
                $query->whereDate('tanggal_pembelian' , $validatedData['tanggal_mulai']);
           } , function($query) use($validatedData) {
                $query->whereBetween('tanggal_pembelian' , [$validatedData['tanggal_mulai'] , $validatedData['tanggal_selesai']]);
           });  

           $sumHarga = $records->sum('harga_total');
           $rowRecords = $records->paginate(5 , ['*'] , 'records_page');
         
        }


        return view('dashboard' , [
            'title' => 'Dashboard Admin',
            'announcements' => $announcement->with('user')->paginate(2 , ['*'] , 'announcement_page'),//merubah nama link pagination menjadi announcement_page
            'votings' => $voting->with('user' , 'announcement')->paginate(2 , ['*'] , 'voting_page'),//merubah nama link pagination menjadi voting_page
            'categories' => Category::latest()->paginate(3, ['*'] , 'categories_page'),
            'categories_for_cutting' => Category::latest()->paginate(3, ['*'] , 'cutting_page'),
            'categories_for_select' => Category::latest()->get(),
            'all_cutting' => CuttingProduk::latest()->get(),
            'selected_announcement' => $selected_announcement,
            'update_announcement' => $update_announcement,
            'update_voting' => $update_voting,
            'update_category' => $update_category,
            'date_now' => Carbon::now(),
            'customer' => $customer,
            'designer' => $designer,
            'unapprove_designer' => $unapprove_designer,
            'produk_terjual_harian' => $produk_terjual_harian,
            'records' => $rowRecords,
            'sumHarga' => $sumHarga
        ]);
    }


    public function generate_pdf(Request $request)
    {
        $records = DB::table('transaction_records')->when($request->tanggal_selesai == 'null' , function($query) use($request) {
            $query->whereDate('tanggal_pembelian' , $request->tanggal_mulai);
       } , function($query) use($request) {
            $query->whereBetween('tanggal_pembelian' , [$request->tanggal_mulai , $request->tanggal_selesai]);
       })->get();  
       
       $tanggal_mulai = $request->tanggal_mulai;
       $tanggal_selesai = $request->tanggal_selesai;

       if($request->tanggal_mulai != 'null'){
        $tanggal_mulai = Carbon::parse($request->tanggal_mulai)->format('Y-M-d');
       }

       if($request->tanggal_selesai != 'null'){
         $tanggal_selesai = Carbon::parse($request->tanggal_selesai)->format('Y-M-d');
       }


       $pdf = PDF::loadView('pdf.record-order' , [
            'records' => $records,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
       ]);

       return $pdf->stream('laporan-penjualan-shalltears.pdf');

      /*  return view('pdf.record-order' , [
        'records' => $records,
        'tanggal_mulai' => $tanggal_mulai,
        'tanggal_selesai' => $tanggal_selesai
   ]); */
    
    }

}
