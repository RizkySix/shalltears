@extends('auth.authMain')

@section('css')
    <link rel="stylesheet" href="/css/verifEmail.css">
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
          <div class="form">
            <p class="text-muted" style="font-size: 14px; text-align:justify; padding:25px">Terima kasih karena kamu sudah mendaftar akun, sebelum memulai silahkan lakukan verifikasi melalui link yang sudah kami kirimkan, jika kamu tidak menerima nya silahkan klik link dibawah untuk mendatpakan link yang baru.</p>

            @if (session('status') == 'verification-link-sent')
               <p class="text-muted" style="font-size: 13px; font-colo:green; font-style:italic; text-align:justify; padding:0px 25px">Link verifikasi email baru sudah dikirim ke email kamu</p>
            @endif
          <div class="d-flex justify-content-around">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                  <button class="button" type="submit"><span>Kirim ulang verifikasi email</span></button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

             <button class="btn btn-link" type="submit" style="color: green">Log Out</button>
            </form>
          </div>
          </div>
        </div>
    </div>
@endsection