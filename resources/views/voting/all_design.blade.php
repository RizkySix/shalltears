@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="col-sm-12 d-flex flex-wrap justify-content-center">
                 @if ($all_design->count())
                 @foreach ($all_design as $design)
                 <div class="card me-4 mb-4" style="width: 24rem;">
                    <a href="{{ asset('storage/' . $design->user_design) }}" data-lightbox="{{ $design->user->nama }}" data-title="Design {{ $design->user->nama }}">
                   <img src="{{ asset('storage/' . $design->user_design) }}" class="card-img-top" height="300" style="object-fit: cover;">
                    </a>
                   <div class="card-body">
                     <h5 class="card-title">{{ $design->judul }}</h5>
                     <p class="card-text">{!! $design->deskripsi  !!}</p>
                       
                     <div class="text-center">
                       <a href="/download-file/{{ $design->id }}" class="">Download File</a>
                     </div>

                        <hr>
                       <div class="d-flex mt-4 justify-content-center">
                           <span>Total Vote : <span class="fw-bold">{{ $design->voted }}</span>
                           @if ($voting_exp <= $date_now && auth()->user()->role == 666)
                           <span class="text-muted">(ID Designer: {{ $design->user_id }})</span>
                           <form action="/selling_produks/create" method="GET" class="d-flex justify-content-center">
                            <input type="hidden" name="the-design-of-user" readonly required value="{{ $design->user_id }}" class="d-none">
                            <button class="btn" style="color:salmon;" type="submit">Buat Produk</button>
                            </form>
                           @endif
                        </span>
                       </div>

                        <hr>
                       <div class="d-flex mt-4 justify-content-center">
                           <span>Design By : <span class="fw-bold">{{ $design->user->nama }}</span></span>
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