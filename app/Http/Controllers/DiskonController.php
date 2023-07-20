<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\SellingProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function create()
    {
        return view('diskon.create' , [
            'title' => 'Buat Promo Diskon'
        ]);
    }

    public function store(Request $request)
    {
       $message = [
        'nama_diskon.min' => 'Minimal 5 karakter',
        'nama_diskon.unique' => 'Nama promo diskon sudah digunakan',
        'tgl_mulai.after' => 'Tanggal mulai diskon minimal satu hari setelah tanggal sekarang',
        'tgl_selesai.after' => 'Tanggal selesai harus diatas tanggal mulai diskon',
       ];
        $validatedData = $request->validate([
            'nama_diskon' => 'required|string|min:5|unique:diskons',
            'persen_diskon' => 'required|numeric',
            'tgl_mulai' => 'required|date|after:' . Carbon::now()->format('Y-m-d'),
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ] , $message);

        $validatedData['tanggal_mulai'] = Carbon::parse($validatedData['tgl_mulai'] . '' . $validatedData['jam_mulai'] . ':' . '01');

        $validatedData['tanggal_selesai'] = Carbon::parse($validatedData['tgl_selesai'] . '' . $validatedData['jam_selesai'] . ':' . '59');
        
        
        Diskon::create($validatedData);
        return back()->with('success' , 'Diskon berhasil dibuat');
    }



    /* Tambah diskon ke produk */
    public function tambah_produk(Request $request)
    {
        if($request->hapus_diskon){
            $validatedData = $request->validate([
                'produk_slug_hapus' => 'required|string|min:5'
            ]);

            SellingProduk::where('slug_id' , $validatedData['produk_slug_hapus'])->update(['diskon_id' => null]);
            return back()->with('success' , 'Produk dihapus dari diskon');
        }
        

        $validatedData = $request->validate([
            'diskon_id' => 'required|integer',
            'slug_produk' => 'required|string|min:5',
        ]);

        SellingProduk::where('slug_id' , $validatedData['slug_produk'])->update(['diskon_id' => $validatedData['diskon_id']]);

        return back()->with('success' , 'Produk ditambahkan ke diskon');
    }


    public function edit(Diskon $diskon)
    {
        $tanggal_mulai  = Carbon::parse($diskon->tanggal_mulai);
        $tgl_mulai = $tanggal_mulai->format('Y-m-d');

        $tanggal_selesai  = Carbon::parse($diskon->tanggal_selesai);
        $tgl_selesai = $tanggal_selesai->format('Y-m-d');

        $jam_mulai = $tanggal_mulai->format('H:i');
        $jam_selesai = $tanggal_selesai->format('H:i');
    
        return view('diskon.edit' , [
            'title' => 'Edit Diskon' , 
            'diskon' => $diskon,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ]);
    }

    public function update_diskon(Request $request , Diskon $diskon)
    {
        $message = [
            'tgl_selesai.after' => 'Tanggal selesai harus diatas tanggal mulai diskon',
           ];
            $rule = [
                'persen_diskon' => 'required|numeric',
                'jam_selesai' => 'required',
            ];

            if($request->nama_diskon != $diskon->nama_diskon){
                $message['nama_diskon.min'] = 'Minimal 5 karakter';
                $message['nama_diskon.unique'] = 'Nama promo diskon sudah digunakan';
                $rule['nama_diskon'] = 'required|string|min:5|unique:diskons';
            }else{
                $message['nama_diskon.min'] = 'Minimal 5 karakter';
                $rule['nama_diskon'] = 'required|string|min:5';
            }

            if($request->tgl_mulai || $request->jam_mulai){
                $tanggal_mulai = Carbon::parse($diskon->tanggal_mulai);
                if($diskon->diskon_start == true){
                    $message['tgl_mulai.date_equals'] = 'Jadwal mulai tidak bisa dirubah karena diskon dalam masa aktif';
                    $message['jam_mulai.date_equals'] = 'Jadwal mulai tidak bisa dirubah karena diskon dalam masa aktif';
                    $rule['tgl_mulai'] = 'required|date|date_equals:' . $tanggal_mulai->format('Y-m-d');
                    $rule['tgl_selesai'] = 'required|date|after:' . Carbon::now()->format('Y-m-d');
                    $rule['jam_mulai'] = 'required|date_equals:' . $tanggal_mulai->format('H:i');
                }else{
                    $message['tgl_mulai.after'] = 'Tanggal mulai diskon minimal satu hari setelah tanggal sekarang';
                    $rule['tgl_mulai'] = 'required|date|after:' . Carbon::now()->format('Y-m-d');
                    $rule['tgl_selesai'] = 'required|date|after:tgl_mulai';
                    $rule['jam_mulai'] = 'required';
                }
            }
    

            $validatedData = $request->validate($rule , $message);

            $validatedData['tanggal_mulai'] = Carbon::parse($validatedData['tgl_mulai'] . '' . $validatedData['jam_mulai'] . ':' . '01');
    
            $validatedData['tanggal_selesai'] = Carbon::parse($validatedData['tgl_selesai'] . '' . $validatedData['jam_selesai'] . ':' . '59');

            Diskon::where('id' , $diskon->id)->update([
                'nama_diskon' => $validatedData['nama_diskon'],
                'persen_diskon' => $validatedData['persen_diskon'],
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
            ]);
            return back()->with('success' , 'Data diskon diperbarui');

    }

    public function aktif_nonaktif(Diskon $diskon)
    {
        if($diskon->status_aktif == true){
            Diskon::where('id' , $diskon->id)->update(['status_aktif' => false]);
        }else{
            Diskon::where('id' , $diskon->id)->update(['status_aktif' => true]);
        }

        return back()->with('success' , 'Status diskon berhasil dirubah');
    }


    public function delete(Diskon $diskon)
    {
        $getProduk = SellingProduk::where('diskon_id' , $diskon->id)->update(['diskon_id' => null]);
        Diskon::destroy($diskon->id);

        return back()->with('success' , 'Diskon berhasil dihapus');
    }


}
