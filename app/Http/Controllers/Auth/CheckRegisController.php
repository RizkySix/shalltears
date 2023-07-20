<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailForDesigner;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckRegisController extends Controller
{
    public function c_regis(User $user, Request $request)
    {
     $users = $user::where('role' , 1306)->where('approve' , false)->where('email_verified_at' , '!=' , null)->orderBy('created_at' , 'ASC');

     if($request->search)
     {
        $users = $user::orderByRaw("nama like '%$request->search%' DESC")->where('role' , 1306)->where('approve' , false)->get();
     }
        return view('auth.c_regis', [
            'title' => "Comfirm Designer",
            "users" => $users->get()
        ]);
    }


    public function approving(Request $request)
    {
       //kirim email apporve ke user
       $data = [
        'subject' => 'Designer Register Confirmation',
        'penerimaan' => 'Konfirmasi Pendaftaran, Kamu Diterima' ,
        'body' => 'Dengan ini kami team Shalltears Clothing Store menerima kamu untuk berkontribusi dalam produksi kami mendatang.Tentu kami mengharapkan design-design yang unik.',
        'nama' => $request->approve_nama,
        'greeting_approve' => 'Perlu bantuan untuk memulai? kamu bisa sign in pada website kami kemudian klik bantuan designer, atau klik link dibawah ini.',
        'confirmation' => 'Selamat bergabung',
        'link_mulai' => 'http://shalltears.test/user-product',
        'link_error' => 'http://shalltears.test/user-product',
    ];

    try{

        //mengirim email ke penerima
        Mail::to($request->approve_email)->send(new MailForDesigner($data));
        }catch(Exception $th){
           return back();
        }

        User::where('id' , $request->approve_id)->update(['approve' => true]);
       return back()->with('success' , 'Pendaftar dengan nama ' . $request->approve_nama . ' diterima');
    }


    
    public function rejecting(Request $request)
    {
        //kirim email reject ke user
       $data = [
        'subject' => 'Designer Register Confirmation',
        'penerimaan' => 'Konfirmasi Pendaftaran, Kamu Belum Diterima' ,
        'body' => 'Tetapi untuk saat ini kami harus menolak pendaftaran anda, mohon maaf atas penolakan yang diberikan. Kami telah menghapus akun dengan email ini, sehingga kamu bisa mencoba daftar designer kembali dengan email yang sama.',
        'nama' => $request->reject_nama,
        'greeting_approve' => 'Tidak puas dengan penolakan ini? kamu bisa menghubungi admin kami, WA:' . auth()->user()->email . '. Atau kamu bisa mendaftar ulang dengan klik link dibawah.',
        'confirmation' => 'Hormat Kami',
        'link_mulai' => 'http://shalltears.test/login',
        'link_error' => 'http://shalltears.test/login',
    ];

    try{

        //mengirim email ke penerima
        Mail::to($request->reject_email)->send(new MailForDesigner($data));
        }catch(Exception $th){
           return back();
        }
        User::destroy('id' , $request->reject_id);
        return back()->with('reject' , 'Pendaftar dengan nama ' . $request->reject_nama . ' ditolak');
    }
}
