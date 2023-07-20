<?php

use App\Mail\MailDesignTerpilih;
use App\Models\DesignPoint;
use App\Models\Diskon;
use App\Models\SellingProduk;
use App\Models\UserDesign;
use App\Models\Voting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

if (!function_exists('less_than_lusin')) {
    function less_than_lusin() {

     $selling = SellingProduk::where('terjual' , '<' , 12)
                            ->where('durasi_point' , '<=' , Carbon::now())
                            ->where('status_expired' , false)
                        ->with(['category' , 'user'])->get();


        foreach($selling as $sell){
       
            $stok = 0;
            foreach($sell->cutting_produks as $cutt_stok){
                $stok += $cutt_stok->pivot->stok_produk;
                $total_stok = $stok + $sell->terjual;
            }

            $persen = 15/100;
            $amount = $sell->harga_produk * $total_stok;
            $bonus_user = $amount * $persen;

           /*  $getPoint = DesignPoint::where('selling_produk_id' , $sell->id)->pluck('point_request');

            if($getPoint->count())
            {
             $point_cair = $getPoint[0];
            }else{
             $point_cair = 0;
            } */
            

            SellingProduk::where('id' ,  $sell->id)->update(['user_point' => $bonus_user  , 'status_expired' => true]);

        }

    }
}


if (!function_exists('diskon_start')) {
    function diskon_start() {

        $getDiskon = Diskon::where('tanggal_mulai' , '<=' , Carbon::now())->get();
        foreach($getDiskon as $diskon){
            Diskon::where('id' , $diskon->id)->where('diskon_start' , false)->update(['status_aktif' => true , 'diskon_start' => true]);
        }
    
    }
}


if (!function_exists('diskon_expired')) {
    function diskon_expired() {

        $getDiskon = Diskon::where('tanggal_selesai' , '<=' , Carbon::now())->get();
        foreach($getDiskon as $diskon){
           SellingProduk::where('diskon_id' , $diskon->id)->update(['diskon_id' => null]);
           Diskon::destroy($diskon->id);
        }
    
    }
}

if (!function_exists('mail_design_terpilih')){
    function mail_design_terpilih(){
        $getVoting = Voting::where('tanggal_expired', '<=' , Carbon::now())->with(['announcement'])->pluck('announcement_id');
        foreach($getVoting as $announcement_id){
            $findDesign = UserDesign::where('announcement_id' , $announcement_id)->with(['announcement' , 'user'])->orderBy('voted' , 'DESC')->first();
         
            $text = [
                'subject' => 'Design Anda Terpilih',
                'design_terpilih' => 'Selamat Design Anda Terpilih',
                'nama' => $findDesign->user->nama,
                'total_vote' => $findDesign->voted,
                'judul_voting' => $findDesign->judul,
            ];

            try{

                //mengirim email ke penerima
                if($findDesign->mailed == false){
                    UserDesign::where('id' , $findDesign->id)->update(['mailed' => true]);
                    Mail::to($findDesign->user->email)->send(new MailDesignTerpilih($text));
                }
                }catch(Exception $th){
               
                }
        }
       
    }
}


if (!function_exists('retrying_send_mail')){
    function retrying_send_mail(){
       $failed_jobs = DB::table('failed_jobs')->count();
       if($failed_jobs > 0){
        Artisan::call('queue:flush');
       }
       
    }
}

?>