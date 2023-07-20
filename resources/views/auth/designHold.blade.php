@extends('auth.authMain')

@section('css')
    <link rel="stylesheet" href="/css/verifEmail.css"> 
    <link rel="stylesheet" href="/css/forgotForm.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
       <style>
           body{
               font-family: 'Itim', cursive !important;
           }
       </style>
@endsection


@section('container')
    <div class="container">
        <div class="konten card">
          <div class="form" style="padding:25px">
            <h5 style="text-align:justify; padding:-10px 25px;">Selangkah Lagi!!!</h5><p class="text-muted" style="font-size: 14px; text-align:justify;">
            Biarkan kami memeriksa gambar design yang anda kirimkan untuk memastikan anda adalah mitra yang baik, tenang saja selama design yang anda kirim sesuai anda pasti kami terima. Email konfirmasi akan dikirim ke alamat email anda dalam 1x24 jam.
            Hubungi kami, 087762582176. 
            </p>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <div class="d-flex">
                <button class="btn btn-link ms-auto" type="submit" style="color: green">Log Out</button>
              </div>
            </form>

          
          </div>
        </div>
    </div>
@endsection