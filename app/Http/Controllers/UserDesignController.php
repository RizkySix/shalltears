<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Partisipan;
use App\Models\PartisipanVoting;
use App\Models\User;
use App\Models\UserDesign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDesignController extends Controller
{
   public function store(Request $request)
   {

        $messages = [
            'user_design.image' => 'Masukan gambar design',
            'user_design.max' => 'Gambar harus dibawah 5mb',
            'file.mimes' => 'Format file harus RaR/Zip'
        ];

        $validatedData = $request->validate([
            'announcement_id' => 'required|integer',
            'judul' => 'required|string',
            'deskripsi' => 'required|string|min:10',
            'user_design' => 'required|image|file|max:5120',
            'file' => 'required|mimes:zip,rar'
        ] , $messages); 

        $validatedData['user_id'] = auth()->user()->id;

        $resDoubleContribute = Partisipan::where('announcement_id' , $validatedData['announcement_id'])->where('partisipan' , auth()->user()->id)->get();
        if($resDoubleContribute->count()){
            return back()->with('success' , 'Kamu sudah berpartisipasi untuk pengumuman tersebut');
        }
            
        
        if($request->file('user_design'))
        {
            $validatedData['user_design'] = $request->file('user_design')->store('user_design');
        }

        if($request->file('file'))
        {
            $validatedData['file'] = $request->file('file')->store('file_design');
        }

        Partisipan::create(['announcement_id' => $validatedData['announcement_id'] , 'partisipan' => $validatedData['user_id']]);
        UserDesign::create($validatedData);
        return back()->with('success' , 'Berhasil berpartisipasi');
       

   }

   public function view_design($announcement)
   {
        $all_design = UserDesign::where('announcement_id' , $announcement)->with(['announcement' , 'user'])
                                ->where('diterima' , false)
                                ->latest()->paginate(20)->withQueryString();
        return view('pengumuman.all_design' , [
            'title' => 'All User Design',
            'all_design' => $all_design
        ]);
   }

   public function view_vote_design($announcement , Request $request)
   {
        $all_design = UserDesign::where('announcement_id' , $announcement)->with(['announcement' , 'user'])
                                ->where('diterima' , true)
                                ->latest()->paginate(20)->withQueryString();
        return view('voting.all_design' , [
            'title' => 'All Vote Design',
            'all_design' => $all_design,
            'date_now' => Carbon::now(),
            'voting_exp' => $request->voting_exp
        ]);
   }


   public function accept(UserDesign $design)
   {
        UserDesign::where('id' , $design->id)->update(['diterima' => true]);
        return back()->with('success' , 'Design diterima');
   }

   public function delete(UserDesign $design)
   {
       if($design->user_design)
       {
        Storage::delete($design->user_design);
       }

       if($design->file)
       {
        Storage::delete($design->file);
       }

       UserDesign::destroy($design->id);
        return back()->with('success' , 'Design ditolak');
   }


   public function voted(UserDesign $design , Request $request)
   {
    $validatedData  = $request->validate([
        'voting_id' => 'required|integer',
        'partisipan' => 'required|integer',
    ]);

    $resDoubleContribute = PartisipanVoting::where('voting_id' , $validatedData['voting_id'])->where('partisipan' , $validatedData['partisipan'])->get();

    if($resDoubleContribute->count())
    {
        return back()->with('success' , 'Anda sudah memberi vote untuk Voting tersebut');
    }
       
         PartisipanVoting::create($validatedData);
        UserDesign::where('id' , $design->id)->update(['voted' => $design->voted += 1]);
        return back()->with('success' , 'Terimakasih untuk vote anda');

   }

     public function download(UserDesign $design)
    {
        if($design->file)
        {
            return Storage::download($design->file);
        }else{
            return back();
        }

   
    }
}
