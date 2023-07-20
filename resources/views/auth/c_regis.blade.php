@extends('components.conten_main')

@section('css')
  
<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">

@endsection

@section('container')
<div class="container">
   <div class="d-flex justify-content-center">
    <div class="conten">
     

        <div class="firstline mb-4 d-flex justify-content-center" style="margin-top: 100px;">
            
            @if (session()->has('success'))
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                <strong>{{ session('success') }}</strong>
                <button type="button" style="color:black;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @endif

                @if (session()->has('reject'))
                <div class="alert alert-danger alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                <strong>{{ session('reject') }}</strong>
                <button type="button" style="color:black;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @endif
           <div class="konten">
                @if ($users->count())
                @foreach ($users as $user)
                <div class="card mb-4" style="width: 25rem;">
                   <a href="{{ asset('storage/' . $user->exmImg) }}" data-lightbox="mygallery" data-title="Design {{ $user->nama }}">
                    <img src="{{ asset('storage/' . $user->exmImg) }}" class="card-img-top" alt="..." width="300" height="300">
                </a>
                    <div class="card-body">
                      <h5 class="card-title">Portofolio calon designer</h5>
                      <p class="card-text">Klik gambar untuk mendapat preview lebih baik.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">{{ $user->nama }}</li>
                      <li class="list-group-item">{{ $user->email }}</li>
                      <li class="list-group-item">Calon designer baru</li>
                    </ul>
                    <div class="card-body">
                        <div  class="d-flex justify-content-around">
                            <form action="{{ route('approve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="approve_id" value="{{ $user->id }}">
                                <input type="hidden" name="approve_nama" value="{{ $user->nama }}">
                                <input type="hidden" name="approve_email" value="{{ $user->email }}">
                                <button class="button" type="submit" style="width:5rem"><span>Terima</span></button>
                            </form>

                            <form action="{{ route('reject') }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="reject_id" value="{{ $user->id }}">
                                <input type="hidden" name="reject_nama" value="{{ $user->nama }}">
                                <input type="hidden" name="reject_email" value="{{ $user->email }}">
                                <button class="button" type="submit" style="width:5rem"><span>Tolak</span></button>
                            </form>
                        </div>
                    </div>
                  </div>
                @endforeach
                @else
                <div class="d-flex justify-content-center align-items-center flex-column" style="margin-top:200px;">
                    <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                    <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                </div>
                @endif
           </div>
        </div>
     
   </div>
   </div>
</div>
@endsection