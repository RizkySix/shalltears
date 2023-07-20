<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Partisipan;
use App\Models\UserDesign;
use App\Models\Voting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all_announcement = Announcement::where('tanggal_expired' , '>' , Carbon::now())->with(['user' , 'category'])->latest()->get();

        if($request->search)
        {
            $all_announcement = Announcement::orderByRaw("judul like '%$request->search%' DESC")->where('tanggal_expired' , '>' , Carbon::now())->where('publikasi_voting' , false)->with(['user' , 'category'])->latest()->get();
        }

        $getPartisipan = Partisipan::all();
       

        return view('pengumuman.view_user' , [
            'title' => 'Semua Pengumuman',
            'all_announcement' => $all_announcement,
            'date_now' => Carbon::now(),
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
            'judul.min' => 'Isi judul pengumuman minimal 8 karakter!',
            'pesan.min' => 'Lengkapi pesan pengumuman minimal 10 karakter!',
            'exam_design.image' => 'Tolong isi dengan file gambar!',
            'exam_design.max' => 'Ukuran gambar harus dibawah 5mb!',
            'durasi.gt' => 'Durasi minimal 1 hari',
        );

        $validatedData = $request->validate([
            'slug_id' => 'unique|string|min:5',
            'judul' => 'required|string|min:8',
            'category_id' => 'required|integer',
            'pesan' => 'required|string|min:10',
            'exam_design' => 'nullable|image|file|max:5120',
            'durasi' => 'required|integer|gt:0'
        ], $messages);

        //generate slug_id dengan faker uuid
        $validatedData['slug_id'] = fake()->uuid();

        //upload gambar
        if($request->file('exam_design')){
            $validatedData['exam_design'] = $request->file('exam_design')->store('gambars_pengumuman');
        }

        //buat rentang waktu expired announcement
        $validatedData['tanggal_expired'] = Carbon::now()->addDays($validatedData['durasi']);

        if(auth()->user()->role == 666){
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['nama_admin'] = auth()->user()->nama;
        }

        Announcement::create($validatedData);
        return back()->with('success' , 'Pengumuman berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
   
        session()->flash('flash_error' , true);

        $messages = array(
            'judul.min' => 'Isi judul pengumuman minimal 8 karakter!',
            'pesan.min' => 'Lengkapi pesan pengumuman minimal 10 karakter!',
            'exam_design.image' => 'Tolong isi dengan file gambar!',
            'exam_design.max' => 'Ukuran gambar harus dibawah 5mb!',
            'durasi.gte' => 'Durasi partisipasi hanya bisa diperpanjang'
        );

        $validatedData = $request->validate([
            'judul' => 'required|string|min:8',
            'category_id' => 'required|integer',
            'pesan' => 'required|string|min:10',
            'exam_design' => 'nullable|image|file|max:5120',
            'durasi' => 'required|integer|gte:'.$announcement->durasi
        ], $messages);


        //buat rentang waktu expired announcement
        if($request->durasi > $announcement->durasi){
            $add_expired_date = $validatedData['durasi'] - $announcement->durasi;
            $validatedData['tanggal_expired'] = $announcement->tanggal_expired->addDays($add_expired_date);
        }
        
        //upload gambar
        if($request->file('exam_design')){
            if($announcement->exam_design){
                Storage::delete($announcement->exam_design);
            }
            $validatedData['exam_design'] = $request->file('exam_design')->store('gambars_pengumuman');
        }

        //update judul voting
        Voting::where('announcement_id' , $announcement->id)->update(['judul_voting' => '@VOTING:'. $validatedData['judul']]);

        Announcement::where('id' , $announcement->id)->update($validatedData);
        return back()->with('success' , 'Pengumuman berhasil diupdate');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
      
        Announcement::destroy($announcement->id);
        return back()->with('success' , 'Pengumuman berhasil dihapus');
    }
}
