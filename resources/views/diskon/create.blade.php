@extends('auth.authMain')

@section('css')
    <link rel="stylesheet" href="/css/button.css">
    <link rel="stylesheet" href="/css/loginregis.css">
    <link rel="stylesheet" href="/css/selling_view.css">
    
    <style>
        body{
            color: aliceblue;
        }
    </style>
@endsection

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex">
                @if (session()->has('success'))
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999; margin-top:50px;">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-center flex-column" style="padding:100px;">
              

                <form action="{{ route('store.diskon') }}" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                    @csrf
                <h4 class="text-center">Buat Promo Diskon.</h4>
                <hr>
             
                <div class="col-sm-6 m-auto d-flex flex-column justify-content-center">
                   <div class="col-sm-8 m-auto">
                     <label for="nama_diskon" class="form-label text-muted">Nama Diskon.</label>
                    <input type="text" name="nama_diskon" id="nama_diskon" class="form-control @error('nama_diskon') is-invalid  @enderror" value="{{ old('nama_diskon') }}" required>
                    @error('nama_diskon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                   </div>

                   <div class="col-sm-8 mt-4 m-auto">
                    <label for="persen_diskon" class="form-label text-muted">Persen Diskon.</label>
                   <input type="number" name="persen_diskon" id="persen_diskon" class="form-control w-50 @error('persen_diskon') is-invalid  @enderror" value="{{ old('persen_diskon') }}" required>
                   @error('persen_diskon')
                       <div class="invalid-feedback">
                           {{ $message }}
                       </div>
                   @enderror
                  </div>

                  <div class="col-sm-8 mt-4 m-auto d-flex">
                    <div class="d-flex flex-column w-50">
                        <label for="tgl_mulai" class="form-label text-muted">Tanggal Mulai.</label>
                            <div class="">
                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control @error('tgl_mulai') is-invalid  @enderror" value="{{ old('tgl_mulai') }}" required>
                            @error('tgl_mulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    </div>

                    <div class="d-flex flex-column w-50 ms-4">
                        <label for="jam_mulai" class="form-label text-muted">Jam Mulai.</label>
                            <div class="">
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid  @enderror" value="{{ old('jam_mulai') }}" required>
                            @error('jam_mulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    </div>
                  </div>

                  <div class="col-sm-8 mt-4 m-auto d-flex">
                    <div class="d-flex flex-column w-50">
                        <label for="tgl_selesai" class="form-label text-muted">Tanggal Selesai.</label>
                            <div class="">
                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control @error('tgl_selesai') is-invalid  @enderror" value="{{ old('tgl_selesai') }}" required>
                            @error('tgl_selesai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    </div>

                    <div class="d-flex flex-column w-50 ms-4">
                        <label for="jam_selesai" class="form-label text-muted">Jam Selesai.</label>
                            <div class="">
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid  @enderror" value="{{ old('jam_selesai') }}" required>
                            @error('jam_selesai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    </div>
                  </div>
                    <hr>
                  <button class="button mt-4"><span>Buat Diskon</span></button>
                </div>

            </form>
            </div>
        </div>
    </div>



@endsection