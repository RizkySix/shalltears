<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\PartisipanVoting;
use App\Models\UserDesign;
use App\Models\Voting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VotingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $votings = Voting::where('exam_design' , '!=' , null)->with(['category' , 'announcement' , 'user'])->latest()->get();

        if($request->search)
        {
            $votings = Voting::orderByRaw("judul_voting like '%$request->search%' DESC")->where('exam_design' , '!=' , null)->with(['category' , 'announcement' , 'user'])->latest()->get();
        }

        $getPartisipan = PartisipanVoting::all();

        $all_design = UserDesign::where('diterima' , true)->with(['user' , 'announcement'])->latest()->get();
        return view('voting.view_vote' , [
            'title' => 'Semua Votingan',
            'votings' => $votings,
            'date_now' => Carbon::now(),
            'designs' => $all_design,
            'partisipans' => $getPartisipan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session()->flash('flash_error' , true);

        $messages = array(
            'judul_voting.min' => 'Isi judul voting minimal 8 karakter!',
            'pesan_voting.min' => 'Lengkapi pesan voting minimal 10 karakter!',
            'durasi_voting.gt' => 'Durasi minimal 1 hari'
        );

        $validatedData = $request->validate([
            'slug_id' => 'unique|string|min:5',
            'announcement_id' => 'required|integer',
            'category_id' => 'required|integer',
            'judul_voting' => 'required|string|min:8',
            'pesan_voting' => 'required|string|min:10',
            'durasi_voting' => 'required|integer|gt:0',
        ], $messages);
        
         //generate slug_id dengan faker uuid
         $validatedData['slug_id'] = fake()->uuid();

        if($request->exam_design){
            $validatedData['exam_design'] = $request->exam_design;
        }

         //buat rentang waktu expired announcement
         $validatedData['tanggal_expired'] = Carbon::now()->addDays($validatedData['durasi_voting']);

        if(auth()->user()->role == 666){
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['nama_admin'] = auth()->user()->nama;
        }

        Announcement::where('id' , $request->announcement_id)->update(['publikasi_voting' => true]);
        Voting::create($validatedData);
        return redirect(route('dashboard'))->with('success' , 'Voting berhasil dibuat cheers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function show(Voting $voting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function edit(Voting $voting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voting $voting)
    {
        session()->flash('flash_error' , true);

        $messages = array(
            'judul_voting.min' => 'Isi judul voting minimal 8 karakter!',
            'pesan_voting.min' => 'Lengkapi pesan voting minimal 10 karakter!',
            'durasi_voting.gte' => 'Durasi voting hanya bisa diperpanjang'
        );

        $validatedData = $request->validate([
            'judul_voting' => 'required|string|min:8',
            'pesan_voting' => 'required|string|min:10',
            'durasi_voting' => 'required|integer|gte:' . $voting->durasi_voting
        ], $messages);

        //buat rentang waktu expired voting supaya hanya bisa diperpanjang
        if($request->durasi_voting > $voting->durasi_voting){
            $add_expired_date = $validatedData['durasi_voting'] - $voting->durasi_voting;
            $validatedData['tanggal_expired'] = $voting->tanggal_expired->addDays($add_expired_date);
        }

      /*   $date = date('Y-m-d' , strtotime('2023-02-19'));
        $god = Carbon::createFromDate($date);
        $god->addDays(5); */

        Voting::where('id' , $voting->id)->update($validatedData);
        return back()->with('success' , 'Voting berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voting $voting)
    {
        if($voting->exam_design){
            Storage::delete($voting->exam_design);
        }

        Voting::destroy($voting->id);
        return back()->with('success' , 'Voting berhasil dihapus');
    }
}
