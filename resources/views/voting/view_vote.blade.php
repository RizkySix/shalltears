@extends('components.conten_main')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('container')
    <div class="container" style="margin-top:150px">
        <div class="row">
            <div class="col-sm-12 ">
                @if (session()->has('success'))
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @endif
                <div class="col-sm-12 d-flex flex-wrap flex-column justify-content-center">
                    @if ($votings->count())
                    @foreach ($votings as $voting)
                    <div class="card col-sm-10 mb-4 m-auto">
        
                        <div class="card-body d-flex">
                            <div class="img me-4">
                                @if ($voting->exam_design)
                                <img src="{{ asset('storage/' . $voting->exam_design) }}" width="500" height="500" style="object-fit: cover;">
                                @else
                                <img src="/imgs/kentang.jpg" width="500" height="500" style="object-fit: cover;">
                                @endif
                            </div>

                          <div class="parts">
                            <h5 class="card-title">{{ $voting->judul_voting }} <span class="text-muted">({{ $voting->category->category_name }})</span></h5>
                          <p class="card-text text-muted">{!! $voting->pesan_voting !!}
                            <br>
                            <br>

                            <div class="text-center mt-auto ">
                                @if ($voting->tanggal_expired < $date_now)
                            <span class="text-danger">Sudah Expired</span>
                           @else
                             @if ($voting->tanggal_expired->diffInDays() >= 1)
                              <span class="text-muted">Partisipasi tersisa {{ $voting->tanggal_expired->diffInDays() }} hari lagi.</span>
                             @else
                             <span class="text-muted">Partisipasi tersisa {{ $voting->tanggal_expired->diffInHours() }} jam lagi.</span>
                             @endif
                             @endif
                            </div>
                           
                        </p>
                        </div>
                    </div>
                           
                                @foreach ($designs as $design)
                                <div class="card-footer">
                                <div class="d-flex">
                                    @if ($design->announcement_id == $voting->announcement_id)
                                        <div class="konten w-100">
                                            <div class="d-flex">
                                                <div class="d-flex justify-content-center me-4">
                                                    <a href="{{ asset('storage/' . $design->user_design) }}" data-lightbox="{{ $design->judul }}" data-title="Design {{ $design->judul }}">
                                                    <img src="{{ asset('storage/' . $design->user_design) }}" alt="rusak" class="img-fluid mt-4"  style="object-fit:cover; width:400px; height:200px;">
                                                    </a>
                                                   </div>
                                                    <div class="mt-4 text-center w-75">
                                                        <h5>{{ $design->user->nama }}</h5>
                                                        <p class="text-muted">
                                                            {!! $design->deskripsi !!}
                                                        </p>
                                                        <span class="h6">Total {{ $design->voted }} vote. 
                                                           
                                                        </span>

                                                        <div class="m-auto">
                                                            @if ($voting->tanggal_expired > $date_now && auth()->user()->role != 666)
                                                           <form action="/design-vote/{{ $design->id }}" method="POST" class="thePart{{ $voting->id }} mt-4 ">
                                                            @method('put')
                                                            @csrf
                                                            <div class="d-flex justify-content-center">
                                                                <input type="hidden" name="voting_id" class="d-none" value="{{ $voting->id }}" readonly>
                                                                <input type="hidden" name="partisipan" class="d-none" value="{{ auth()->user()->id }}" readonly>
                                                                <button class="button"><span>Vote</span></button>
                                                            </div>
                                                        </form>
                                                           @endif
                                                           </div>
                                                        
                                                    </div>
                                            </div>
                                              
                                        </div>
                                    @endif
                                </div>
                            </div>

                                @foreach($partisipans as $part)
                              
                                @if($part->partisipan == auth()->user()->id && $voting->id == $part->voting_id)
                                  <script>
                                      $(document).ready(function(){
                                          $('.thePart{{ $voting->id }}').css('display' , 'none')
                                      })
                                  </script>
                                @endif
                            @endforeach
                              
                            @endforeach
                        

                        
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

  
@endsection