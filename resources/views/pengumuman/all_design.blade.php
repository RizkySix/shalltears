@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12 ">
                @if (session()->has('success'))
              <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              
              @endif
                <div class="col-sm-12 d-flex flex-wrap justify-content-center">
                 @if ($all_design->count())
                 @foreach ($all_design as $design)
                 <div class="card me-4 mb-4" style="width: 24rem;">
                  <a href="{{ asset('storage/' . $design->user_design) }}" data-lightbox="{{ $design->user->nama }}" data-title="Design {{ $design->user->nama }}">
                   <img src="{{ asset('storage/' . $design->user_design) }}" class="card-img-top" height="300" style="object-fit: cover;">
                  </a>
                   <div class="card-body">
                     <h5 class="card-title">{{ $design->announcement->judul }}</h5>
                     <p class="card-text">{!! $design->deskripsi  !!}</p>
                       
                     <div class="text-center">
                       <a href="/download-file/{{ $design->id }}" class="">Download File</a>
                     </div>

                       <div class="d-flex mt-4 justify-content-around">
                           <form action="/design-acc/{{ $design->id }}" method="POST">
                               @csrf
                               @method('put')
                               <button class="button"><span>Terima</span></button>
                           </form>
                           <form action="/design-del/{{ $design->id }}" method="POST">
                               @csrf
                               @method('delete')
                               <button class="button"><span>Tolak</span></button>
                           </form>
                       </div>
                   </div>
                 </div>
                 @endforeach
                 <div class="d-flex justify-content-center mt-4">
                  {{ $all_design->links() }}
                 </div>
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

  
@endsection