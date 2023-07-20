@extends('components.conten_main')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">

<style>
    .error-feedback{
            font-size: .875em;
            color: #dc3545;
        }
</style>
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
                    @if ($all_announcement->count())
                    @foreach ($all_announcement as $announcement)
                    <div class="card col-sm-10 m-auto" style="margin-bottom:50px !important;">
                  
                        <div class="card-body d-flex">
                         <div class="gambar me-4">
                          @if ($announcement->exam_design)
                          <img src="{{ asset('storage/' . $announcement->exam_design) }}" class="" width="500" height="500" style="object-fit: cover;">
                          @else
                          <img src="/imgs/kentang.jpg" class="" width="500" height="500" style="object-fit: cover;">
                          @endif
                         </div>
                          <div class="parts">
                            <h5 class="card-title">{{ $announcement->judul }} <span class="text-muted">({{ $announcement->category->category_name }})</span></h5>
                          <p class="card-text text-muted">{!! $announcement->pesan !!}
                            <br>
                            <br>
                              @if ($announcement->exam_design)
                                <div class="text-center">
                                  @if ($announcement->tanggal_expired < $date_now)
                                     <span class="text-danger">Sudah Expired</span>
                                 @else
                              @if ($announcement->tanggal_expired->diffInDays() >= 1)
                                   <span class="text-muted">Partisipasi tersisa {{ $announcement->tanggal_expired->diffInDays() }} hari lagi.</span>
                              @else
                                   <span class="text-muted">Partisipasi tersisa {{ $announcement->tanggal_expired->diffInHours() }} jam lagi.</span>
                              @endif
                              <br>
                              <span class="text-muted" style="display: none;" id="altr{{ $announcement->id }}">Anda sudah berpartisipasi untuk pengumuman ini.</span>
                              </div>
                              @endif
                         @endif
                        </p>
                                          
                        @if ($announcement->exam_design && auth()->user()->role == 1306)
                        <form action="/send-design" method="POST" class="needs-validation" novalidate enctype="multipart/form-data" id="thePart{{ $announcement->id }}">
                            @csrf
                            <div id="exmImg">
            
                                <img src="" class="img-preview img-fluid d-block mb-2" id="img-preview{{ $announcement->id }}">
                                <label for="gmb{{ $announcement->id }}" class="lblGmb form-label" id="szz">
                                  Upload file
                                </label>
                                <input type="file" class="gambarEx form-control d-none" name="user_design" id="gmb{{ $announcement->id }}" onchange="previewImage{{ $announcement->id }}()" required>
                                @error('user_design')
                                <div class="error-feedback">
                                 {{ $message }}
                                </div>
                               @enderror

                               <input type="hidden" name="judul" class="d-none" value="{{ $announcement->judul }}" readonly required>

                                <label for="file" class="text-muted">Masukkan file Rar/Zip design</label>
                                <input type="file" id="file" name="file" class="form-control w-50" required>
                                @error('file')
                                 <div class="error-feedback">
                                  {{ $message }}
                                 </div>
                                @enderror
                              </div>

                              <div class="form-floating">
                                <textarea class="form-control" name="deskripsi" placeholder="Leave a comment here" id="floatingTextarea{{ $announcement->id }}" required style="height: 120px;">{{ old('deskripsi') }}</textarea>
                                <label for="floatingTextarea{{ $announcement->id }}">Deskripsi Design...</label>
                              </div>

                              <input type="hidden" name="announcement_id" class="d-none" value="{{ $announcement->id }}" readonly>
                              <input type="hidden" name="partisipan" class="d-none" value="{{ auth()->user()->id }}" readonly>
                              <div class="justify-content-center mt-4" id="partisipan_btn" style="display: flex;">
                                <button class="button"><span>Kirim</span></button>
                              </div>

                              @foreach($partisipans as $part)
                              
                                  @if($part->partisipan == auth()->user()->id && $announcement->id == $part->announcement_id)
                                    <script>
                                        $(document).ready(function(){
                                            $('#thePart{{ $announcement->id }}').css('display' , 'none')
                                            $('#altr{{ $announcement->id }}').show();
                                        })
                                    </script>
                                  @endif
                              @endforeach
                              
                        </form>
                        @endif
                          </div>
                        </div>
                      </div>
                      <script>
                         function previewImage{{ $announcement->id }}()
                     {
                       const image = document.querySelector('#gmb{{ $announcement->id }}');
                       const imgPreview = document.querySelector('#img-preview{{ $announcement->id }}');
    
                       imgPreview.style.display = 'block';
                      
                     
                       const blob = URL.createObjectURL(image.files[0]);
                       imgPreview.src = blob;
                     }
                      </script>

                      

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