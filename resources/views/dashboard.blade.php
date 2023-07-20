@extends('components.conten_main')

@section('css')

<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">

@endsection

@section('container')
    <div class="container mb-4" style="margin-top:100px">
      <div class="row">
        
        <div class="clm col-sm-3">
          <div class="card">
            <div class="card-body">
              
              @if (session()->has('success'))
              <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              
              @endif
              <span class="float-start" style="padding:20px 10px; ">
                <i class="fas fa-solid fa-rocket fa-4x" style="color:rgb(224, 224, 114); "></i>
              </span>
              <div class="d-flex flex-column text-center">
                <span style="font-size: 19px; font-weight:600">Produk terjual harian</span>
                <span class="mt-3">Total : <a href="#" class="text-decoration-none">
                  @php
                      $sold_harian = 0;
                  @endphp  

                  @foreach ($produk_terjual_harian as $sold_qty)
                      @php
                          $sold_harian += $sold_qty->qty;
                      @endphp
                  @endforeach
                  {{ $sold_harian }}
                </a></span>
              </div>
            </div>
          </div>
        </div>
        <div class="clm col-sm-3">
          <div class="card">
            <div class="card-body">
              <span class="float-start" style="padding:20px 10px; ">
                <i class="fa-sharp fa-solid fa-sack-dollar fa-4x" style="color:rgb(77, 11, 139)"></i>
              </span>
              <div class="d-flex flex-column text-center">
                <span style="font-size: 19px; font-weight:600">Revenue Harian</span>
                <span class="mt-3">Total : <a href="#" class="text-decoration-none">
                  @php
                      $total_rev = 0;
                  @endphp
                  @foreach ($produk_terjual_harian as $revenue)
                      @php
                          $firstForOne = $revenue->harga * $revenue->qty;
                          $total_rev += $firstForOne;
                      @endphp
                  @endforeach  
                Rp {{ str_replace(',' , '.' , number_format($total_rev)) }}
                </a></span>
              </div>
            </div>
          </div>
        </div>
        <div class="clm col-sm-3">
          <div class="card">
            <div class="card-body">
              <span class="float-start" style="padding:20px 10px; ">
                <i class="fas fa-duotone fa-user-secret fa-4x" style="color:rgb(156, 143, 160)"></i>
              </span>
              <div class="d-flex flex-column text-center">
                <span style="font-size: 19px; font-weight:600">Jumlah Customer</span>
                <span class="mt-3">Total : <a href="#" class="text-decoration-none">{{ $customer->count() }}</a></span>
              </div>
            </div>
          </div>
        </div>
        <div class="clm col-sm-3">
          <div class="card">
            <div class="card-body position-relative">
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning" style="width: 100px">
               <a href="{{ route('c_regis') }}" class="text-decoration-none text-wrap" style="color:aliceblue;">Konfirmasi Designer <span style="color: red">{{ $unapprove_designer->count() }}</span></a>
              </span>
              <span class="float-start" style="padding:20px 10px; ">
                <i class="fas fa-solid fa-user-astronaut fa-4x" style="color:rgb(153, 81, 35)"></i>
              </span>
              <div class="d-flex flex-column text-center">
                <span style="font-size: 19px; font-weight:600">Jumlah Designer</span>
                <span class="mt-3">Total : <a href="#" class="text-decoration-none">{{ $designer->count() }}</a></span>
              </div>
            </div>
          </div>
        </div>


        <div class="col-sm-12 mt-4">
          <div class="card">
            <div class="card-body">

              <div class="col-sm-7">
               <form action="/dashboard" class="d-flex justify-content-between mb-3" method="GET">
               <div class="d-flex">
                <input type="date" class="form-control me-2" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" required>
                <span class="text-muted me-2">~sampai~</span>
                <input type="date" class="form-control me-2" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                <button class="btn btn-primary">Cari</button>
              </form>

              @php
                  $queryTanggalMulai = 'null';
                  $queryTanggalSelesai = 'null';
                  if(request('tanggal_mulai') != null){
                    $queryTanggalMulai = request('tanggal_mulai');
                  }
                  if(request('tanggal_selesai') != null){
                    $queryTanggalSelesai = request('tanggal_selesai');
                  }
              @endphp

              <form action="/pdf-record/{{ $queryTanggalMulai }}/{{ $queryTanggalSelesai }}" method="GET" target="__blank">
                <button class="btn btn-dark ms-2" >PDF</button>
              </form>
               </div>
              @error('tanggal_mulai')
                  {{ $message }}
              @enderror
              @error('tanggal_selesai')
                  {{ $message }}
              @enderror
              </div>
              
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Pembelian</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga Satuan</th>
                    <th scope="col">Harga Total</th>
                    <th scope="col">Status Pesanan</th>
                  </tr>
                </thead>
             @if ($records == null || !$records->count())
              <tbody>
                <tr>
                  <th scope="row">#</th>
                  <td colspan="6"  class="text-center"><span class="fw-bold">Tidak Ada Data!</span></td>
                </tr>
              </tbody>

            @else
            <tbody>
            @foreach ($records as $record)
           
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                @php
                    $tanggal_pembelian = Carbon\Carbon::parse($record->tanggal_pembelian)->format('Y-M-d');
                    $harga_satuan = number_format($record->harga_satuan);
                    $harga_total = number_format($record->harga_total);
                @endphp
                <th scope="row">{{ $tanggal_pembelian }}</th>
                <th scope="row">{{ $record->nama_produk }}</th>
                <th scope="row">{{ $record->qty }}</th>
                <th scope="row">Rp. {{ $harga_satuan }}</th>
                <th scope="row">Rp. {{ $harga_total }}</th>
                <th scope="row"><span style="text-transform:capitalize;">{{ $record->transaction_status }}</span></th>
              
              </tr>
             
          
            @endforeach
            <tr style="font-size:18px;">
              <th><span class="fw-bold">Total Uang Masuk</span></th>
              @php
                  $sumHarga = number_format($sumHarga);
              @endphp
              <td colspan="6" class="text-end"><span class="fw-bold">Rp. {{ $sumHarga }}</span></td>
            </tr>
          </tbody>
             @endif

          
            </table>
            
            @if (!$records == null)
    
            {{ $records->appends(request()->query())->links() }}
            @endif

            </div>
          </div>
        </div>

      
        {{-- row baris 2 --}}
        <div class="col-sm-4 mt-4">
          @if (request('announcement_id') && !$selected_announcement->isEmpty())

          <div class="card">
            <div class="card-header bg-danger text-center">
              <span style="font-size: 19px; font-weight:600">Buat Voting</span>
            </div>
            <div class="card-body">
          

            <form action="{{ route('votings.store') }}" method="POST" class="needs-validation" novalidate style="padding:20px;">
              @csrf 
              @foreach($selected_announcement as $selected)
              <label for="judul_voting" class="form-label text-muted">Judul Voting.</label>
              <input type="text" class="form-control  @error('judul_voting') is-invalid @enderror"  name="judul_voting" id="judul_voting" value="@VOTING:{{ $selected->judul }}" required readonly autocomplete="off">
              @error('judul_voting')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <input type="hidden" class="d-none" name="announcement_id" value="{{ $selected->id }}">

              <label for="kategori" class="form-label mt-3 text-muted">Kategori.</label>
              <input type="hidden" class="d-none" name="category_id" value="{{ $selected->category_id }}" required>
              @if ($selected->category_id == 0)
                  <input type="text" class="form-control" value="Voting biasa (tidak ada kategori)." readonly>
                @else
                <input type="text" class="form-control" value="{{ $selected->category->category_name }}" readonly>
              @endif
              
              @error('category_id')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror
            
              <label for="pesan_voting" class="form-label mt-3 text-muted">Pesan.</label>
              <textarea type="text" rows="6" cols="10" name="pesan_voting" class="form-control @error('pesan_voting') is-invalid @enderror " required>{{ old('pesan_voting') }}</textarea>
              @error('pesan_voting')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <label for="gambar_design" class="form-label text-muted mt-3">Contoh Gambar Design.</label>
              @if ($selected->exam_design)
              <input type="hidden" class="d-none" name="exam_design" value="{{ $selected->exam_design }}">
              <img src="{{ asset('storage/' .  $selected->exam_design) }}" class="img-fluid d-block mb-2 " style="width: 200px; height:150px">
              @else
              <img src="/imgs/kentang.jpg" class="img-fluid d-block mb-2 " style="width: 200px; height:150px">
              @endif
      
              <label for="durasi_voting" class="form-label mt-2 text-muted">Durasi Voting.</label>
              <div class="input-group mb-3 w-50">
                <input type="number" class="form-control  @error('durasi_voting') is-invalid @enderror " name="durasi_voting" value="{{ old('durasi_voting') }}" required>
                <span class="input-group-text text-muted bg-info" id="basic-addon2" style="font-size:12px">Hari</span>
                @error('durasi_voting')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
              </div>

              <button class="button"><span>Buat</span></button>
              @endforeach
            </form>
            </div>
          </div>

          {{-- form update voting --}}
          @elseif(request('voting_update') && !$update_voting->isEmpty())
          <div class="card">
            <div class="card-header bg-danger text-center">
              <span style="font-size: 19px; font-weight:600">Update Voting</span>
            </div>
            <div class="card-body">
          

            <form action="{{ route('votings.update' , request('voting_update')) }}" method="POST" class="needs-validation" novalidate style="padding:20px;">
              @csrf 
              @method('put')
              @foreach($update_voting as $voting_upd)
              <label for="judul_voting" class="form-label text-muted">Judul Voting.</label>
              <input type="text" class="form-control  @error('judul_voting') is-invalid @enderror"  name="judul_voting" id="judul_voting" value="{{ $voting_upd->judul_voting }}" required readonly autocomplete="off">
              @error('judul_voting')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <label for="kategori" class="form-label mt-3 text-muted">Kategori.</label>
              @if ($voting_upd->category_id == 0)
                  <input type="text" class="form-control" value="Voting biasa (tidak ada kategori)." readonly>
                @else
                <input type="text" class="form-control" value="{{ $voting_upd->category->category_name }}" readonly>
              @endif
              
              @error('category_id')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror
            
              <label for="pesan_voting" class="form-label mt-3 text-muted">Pesan.</label>
              <textarea type="text" rows="6" cols="10" name="pesan_voting" class="form-control @error('pesan_voting') is-invalid @enderror " required>{{ old('pesan_voting' , $voting_upd->pesan_voting) }}</textarea>
              @error('pesan_voting')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <label for="gambar_design" class="form-label text-muted mt-3">Contoh Gambar Design.</label>
              @if ($voting_upd->exam_design)
              <img src="{{ asset('storage/' .  $voting_upd->exam_design) }}" class="img-fluid d-block mb-2 " style="width: 200px; height:150px">
              @else
              <img src="/imgs/kentang.jpg" class="img-fluid d-block mb-2 " style="width: 200px; height:150px">
              @endif
      
              <label for="durasi_voting" class="form-label mt-2 text-muted">Durasi Voting.</label>
              <div class="input-group mb-3 w-50">
                <input type="number" class="form-control  @error('durasi_voting') is-invalid @enderror " name="durasi_voting" value="{{ old('durasi_voting' , $voting_upd->durasi_voting) }}" required>
                <span class="input-group-text text-muted bg-info" id="basic-addon2" style="font-size:12px">Hari</span>
                @error('durasi_voting')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
              </div>

              <button class="button"><span>Update</span></button>
              @endforeach
            </form>
            </div>
          </div>

          {{-- form update pengumuman --}}
          @elseif(request('update_announcement') && !$update_announcement->isEmpty())
          <div class="card">
            <div class="card-header bg-warning text-center">
              <span style="font-size: 19px; font-weight:600">Update Pengumuman</span>
            </div>
            <div class="card-body">


              <form action="{{ route('announcements.update' , request('update_announcement')) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data" style="padding:20px;" autocomplete="off">
                @method('put')
                @csrf 
          
                @foreach($update_announcement as $announ_upd)
                <label for="judul" class="form-label text-muted">Judul Pengumuman.</label>
                <input type="text" class="form-control  @error('judul') is-invalid @enderror"  name="judul" id="judul" value="{{ old('judul' , $announ_upd->judul) }}" required autocomplete="off">
                @error('judul')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
  
                <label for="kategori" class="form-label mt-3 text-muted">Kategori.</label>
                <select name="category_id" id="kategori" class="form-select  @error('category_id') is-invalid @enderror " required>
                  <option value="0" @if($announ_upd->category_id == 0) selected @endif>Tidak memilih kategori</option>
                  
                  @foreach ($categories_for_select as $category)
                     <option value="{{ $category->id }}"
                      @if($category->id == $announ_upd->category_id && !old('category_id'))
                      selected
                      @elseif(old('category_id') == $category->id)
                      selected
                      @endif
                      >{{ $category->category_name }}</option>
                 @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
              
                <label for="pesan" class="form-label mt-3 text-muted">Pesan.</label>
                <textarea type="text" rows="6" cols="10" name="pesan" class="form-control @error('pesan') is-invalid @enderror " required>{{ old('pesan' , $announ_upd->pesan) }}</textarea>
                @error('pesan')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
  
                @if ($announ_upd->exam_design)
                    <img src="{{ asset('storage/' . $announ_upd->exam_design) }}" alt="" class="img-preview img-fluid d-block mb-2 mt-3" >
                @else
                <img src="/imgs/kentang.jpg" alt="" class="img-preview img-fluid d-block mb-2 mt-3 " >
                @endif
                <label for="gmb" class="lblGmb form-label" id="szz">
                Ganti Example Design
                </label>
              
                <input type="file" class="gambarEx form-control d-none  @error('exam_design') is-invalid @enderror " name="exam_design" id="gmb" onchange="previewImage()">
                @error('exam_design')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
                <br>
                <label for="durasi" class="form-label mt-2 text-muted">Durasi.</label>
                <div class="input-group mb-3 w-50">
                  <input type="number" class="form-control  @error('durasi') is-invalid @enderror " name="durasi" value="{{ old('durasi' , $announ_upd->durasi) }}" required>
                  <span class="input-group-text text-muted bg-info" id="basic-addon2" style="font-size:12px">Hari / 1x24 jam</span>
                  @error('durasi')
                  <div class="invalid-feedback">
                  {{ $message }}
                  </div>
                  @enderror
                </div>
  
                <button class="button"><span>Update</span></button>
                @endforeach
              </form>
            </div>
          </div>

          @else {{-- jika tidak ada request announcement id tampilkan form buat penguman dll --}}

          <div class="card">
            <div class="card-header bg-warning text-center">
              <span style="font-size: 19px; font-weight:600">Buat Pengumuman dan Category</span>
            </div>
            <div class="card-body">

             <div id="carouselForm1" class="carousel slide">
                <div class="carousel-inner">
                  <div class="carousel-item @if(!session('on_category_form') && !request('categories_page') && !request('categories_update')) active @endif">


            <form action="{{ route('announcements.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data" style="padding:20px;">
              @csrf 
           
              <label for="judul" class="form-label text-muted">Judul Pengumuman.</label>
              <input type="text" class="form-control  @error('judul') is-invalid @enderror"  name="judul" id="judul" value="{{ old('judul') }}" required style="position:relative; z-index:999;" autocomplete="off">
              @error('judul')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <label for="kategori" class="form-label mt-3 text-muted">Kategori.</label>
              <select name="category_id" id="kategori" class="form-select  @error('category_id') is-invalid @enderror " required style="position:relative; z-index:999;">
                <option value="0">Tidak memilih kategori</option>
                  @foreach ($categories_for_select as $category)
                      <option value="{{ $category->id }}" 
                        @if($category->id == 1 && !old('category_id'))
                         selected 
                         @elseif(old('category_id') == $category->id)
                         selected
                         @endif>{{ $category->category_name }}</option>
                  @endforeach
              </select>
              @error('category_id')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror
            
              <label for="pesan" class="form-label mt-3 text-muted">Pesan.</label>
              <textarea type="text" rows="6" cols="10" name="pesan" class="form-control @error('pesan') is-invalid @enderror " value="" required style="position:relative; z-index:999;">{{ old('pesan') }}</textarea>
              @error('pesan')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror

              <img src="" class="img-preview img-fluid d-block mb-2 mt-3">
              <label for="gmb" class="lblGmb form-label" id="szz" style="position:relative; z-index:999;">
               Example design
              </label>
            
              <input type="file" class="gambarEx form-control d-none  @error('exam_design') is-invalid @enderror " name="exam_design" id="gmb" onchange="previewImage()">
              @error('exam_design')
              <div class="invalid-feedback">
              {{ $message }}
              </div>
              @enderror
              <br>
              <label for="durasi" class="form-label mt-2 text-muted">Durasi.</label>
              <div class="input-group mb-3 w-50">
                <input type="number" class="form-control  @error('durasi') is-invalid @enderror " name="durasi" value="{{ old('durasi') }}" required style="position:relative; z-index:999;">
                <span class="input-group-text text-muted bg-info" id="basic-addon2" style="font-size:12px; width:30%;">Hari</span>
                @error('durasi')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
              </div>

              <button class="button" style="position:relative; z-index:999;"><span>Buat</span></button>

            </form>

            </div>
            
            {{-- Buat kategory baru --}}
            <div class="carousel-item @if(session('on_category_form')) active @endif">

           
             <form action="{{ route('categories.store') }}" method="POST" class="needs-validation" novalidate style="padding:20px;">
              @csrf
              <span class="d-flex">#Buat category baru.</span><br>
                <label for="category_name" class="form-label text-muted">Nama Kategori.</label>
                <input type="text" name="category_name" value="{{ old('category_name') }}" class="form-control  @error('category_name') is-invalid @enderror" required style="position: relative; z-index:999;">
                @error('category_name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

                <label for="tipe_barang" class="form-label text-muted mt-3">Tipe Barang.</label>
                <input type="text" name="tipe_barang" class="form-control @error('tipe_barang') is-invalid @enderror" placeholder="Contoh: Atasan,Outer" value="{{ old('tipe_barang') }}" required style="position: relative; z-index:999;">
                @error('tipe_barang')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror

                <button class="button mt-3" style="position: relative; z-index:999;"><span>Buat</span></button>
            </form>
            </div>

            {{-- Semua category --}}
            <div class="carousel-item @if(request('categories_page')) active @endif)">
             @if ($categories->count())
                @foreach ($categories as $category)
                <div class="d-flex justify-content-center" style="padding:20px">
                  <div class="col-sm-4">{{ $loop->iteration }}. {{ $category->category_name }}</div>
                  <form action="{{ route('dashboard') }} " method="GET">
                    <input type="hidden" name="categories_update" value="{{ $category->id }}" class="d-none">
                    <button class="badge bg-warning"> <i class="fas fa-solid fa-rocket"></i></button>
                  </form>
                </div>
              <div class="d-flex justify-content-center">
                <hr class="w-50">
              </div>
              @endforeach
                <div class="d-flex justify-content-center">
                  {{ $categories->links() }}
                </div>
              @else
              <p class="text-muted">Tidak ada category.</p>
             @endif
            </div>

          

          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselForm1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselForm1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>

          {{-- Update category --}}
          @if (request('categories_update'))
          <div>
            <form action="{{ route('categories.update' , request('categories_update')) }}" method="POST" class="needs-validation" novalidate style="padding:20px;">
             @csrf
             @method('put')
             <span class="d-flex">#Update category.</span><br>
              @foreach ($update_category as $category_upd)
               <label for="category_name" class="form-label text-muted">Nama Kategori.</label>
               <input type="text" name="category_name" value="{{ old('category_name' , $category_upd->category_name) }}" class="form-control @error('category_name') is-invalid @enderror" required style="position: relative; z-index:999;">
               @error('category_name')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror

               <label for="tipe_barang" class="form-label text-muted mt-3">Tipe Barang.</label>
               <input type="text" name="tipe_barang" class="form-control @error('tipe_barang') is-invalid @enderror" placeholder="Contoh: Atasan,Outer" value="{{ old('tipe_barang' , $category_upd->tipe_barang) }}" required style="position: relative; z-index:999;">
               @error('tipe_barang')
               <div class="invalid-feedback">
                 {{ $message }}
               </div>
               @enderror

               <button class="button mt-3" style="position: relative; z-index:999;"><span>Update</span></button>
               @endforeach
           </form>
           </div>
          @endif
        

            </div>
          </div>

          @endif
        </div>

        {{-- baris ke 2 line 2 --}}
        <div class="col-sm-4 mt-4">
          <div class="card">
            <div class="card-header bg-warning text-center">
              <span style="font-size: 19px; font-weight:600">Daftar Pengumuman,Voting, dan Buat Cutting</span>
            </div>
            <div class="card-body">
              <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                  <div class="carousel-item @if(!session('create_cutting') && !session('update_cutting') && !request('cutting_page')) active @endif">
                    <div class="d-flex justify-content-center">
                      <div class="d-flex justify-content-center w-75 flex-column">
                        <button type="button" class="btn btn-warning btn-lg btn3d" data-bs-toggle="modal" data-bs-target="#daftarPengumuman" id="btn_pengumuman"><span class="glyphicon glyphicon-warning-sign"></span> <i class="fa-sharp fa-solid fa-bullhorn"></i>  Daftar pengumuman</button>
                        <button type="button" class="btn btn-primary btn-lg btn3d" data-bs-toggle="modal" data-bs-target="#daftarVoting" id="btn_voting"><span class="glyphicon glyphicon-cloud"></span><i class="fa-sharp fa-solid fa-hand-point-up"></i> Daftar voting</button>
                        <a type="button" href="{{ route('selling_produks.index') }}" class="btn btn-danger btn-lg btn3d text-decoration-none" style="color:aliceblue;"><span class="glyphicon glyphicon-remove"></span><i class="fa-sharp fa-solid fa-lock-open"></i> Produk Dipublish</a>
                      </div>
                    </div>
                  </div>

                  <div class="carousel-item @if(session('create_cutting')) active @endif" style="padding:20px;">
                    <form action="{{ route('cutting_produks.store') }}" method="POST" class="needs-validation" novalidate style="position: relative; z-index:999999;">
                      @csrf
                      <label for="category_id" class="form-label text-muted">Pilih category.</label>
                      <select name="category_id" id="category_id" class="form-select" required>
                          @foreach ($categories_for_select as $category)
                              <option value="{{ $category->id }}"
                                @if ($category->id == session('create_cutting'))
                                    selected
                                @endif
                                >{{ $category->category_name }}
                              </option>
                          @endforeach
                      </select>

                      <label for="cutting_name" class="form-label text-muted mt-3">Nama ukuran.</label>
                      <input type="text" name="cutting_name" class="form-control" placeholder="XL/42" value="{{ old('cutting_name') }}" required>
                      @if (session('similiarSize'))
                      <span style="font-size: .875em; color: #dc3545;">Size {{ session('similiarSize') }} sudah ada, coba size lain!.</span>
                      @endif
                      <button class="button mt-3"><span>Buat</span></button>
        
                    </form>
                  </div>
                  
                  <div class="carousel-item text-center @if(session('update_cutting') && !session('create_cutting') || request('cutting_page') && !session('create_cutting')) active @endif" style="padding:20px 50px;">
                  @if($categories_for_cutting->count())
                   @foreach ($categories_for_cutting as $cutting)
                   
                      <div class="d-flex justify-content-center">
                        <span>{{ $loop->iteration }}. {{ $cutting->category_name }}</span>
                      </div>
                     
                      @if (session('same'))
                        @if (session('same')['id_session'] == $cutting->id)
                        <span style="font-size: .875em; color: #dc3545;">Size {{ session('same')['messages'] }} sudah ada, coba size lain!.</span>
                        @endif
                      @endif
                      
                     
                      <div class="d-flex justify-content-around flex-wrap">
                            @foreach ($cutting->cutting_produk as $value)  
       
                          <form action="{{ route('cutting_produks.update' , $value->id) }}" method="POST" class="needs-validation mt-2 w-25" style="margin-right:5px;" novalidate>
                            @csrf
                            @method('put')
                                 
                            <input type="hidden" class="w-100  mt-2 text-center d-none" style="margin-right:2px;" name="old_cutting_name" value="{{ $value->cutting_name }}">
                            <div class="position-relative mt-4" style="z-index: 999; margin-right:10px;">
                              <input type="text" class="w-100 text-center"  name="cutting_name" value="{{ $value->cutting_name }}">  
                              <button class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning">
                                <span  class="text-decoration-none text-wrap" style="color:aliceblue;">G</span>
                              </button>

                              <button type="button" id="delSize{{ $value->id }}" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                              </button>
                           
                            </div>
                           
                            </form>

                          

                            <script>
                             
                              //bisa memakai ajax untuk mengakali logika delete seperti ini
                              $('#delSize{{ $value->id }}').click(function(){

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Pastikan size ini sedang tidak terpakai pada produk yang dijual!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sip, lanjut!'
                                  }).then((result) => {
                                    if (result.isConfirmed) {

                                      //jika alert comfirm atau setuju delete kemudian panggil ajax
                                        $.ajax({
                                      url: '/cutting_produks/' + {{ $value->id }},
                                      type: 'DELETE',
                                      data: {
                                        "_token": "{{ csrf_token() }}"
                                      },
                                      success: function() {
                                      location.reload();
                                      },
                                      error: function(xhr) {
                                        alert('something wrong')
                                      }
                                    });
                                    //####################################
                                    }
                                  })
                                  
                                 
                                });

                                
                            </script>
  
                            @endforeach

                          </div>
                      
                      <hr>
 
                   @endforeach
                   <div class="d-flex justify-content-center">
                    {{ $categories_for_cutting->links() }}
                  </div>

                   @endif
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- Baris 3 untuk pengelolaan pesanan dan permintaan penarikan point --}}
        <div class="col-sm-4 mt-4">
          <div class="card">
            <div class="card-header bg-warning text-center">
              <span style="font-size: 19px; font-weight:600">Pesanan dan Point</span>
            </div>
            <div class="card-body d-flex justify-content-center">
              <div class="d-flex justify-content-center w-75 flex-column">
                <a type="button" href="/admin-dipesan" target="___blank" class="btn btn-warning btn-lg btn3d text-decoration-none" style="color:aliceblue;"><span class="glyphicon glyphicon-remove"></span><i class="fa-sharp fa-solid fa-hourglass-start"></i> Dipesan</a>

                <a type="button" href="/admin-dikirim" target="___blank" class="btn btn-primary btn-lg btn3d text-decoration-none" style="color:aliceblue;"><span class="glyphicon glyphicon-remove"></span><i class="fa-sharp fa-solid fa-ship"></i> Dikirim</a>

                <a type="button" href="/admin-selesai" target="___blank" class="btn btn-danger btn-lg btn3d text-decoration-none" style="color:aliceblue;"><span class="glyphicon glyphicon-remove"></span><i class="fa-sharp fa-solid fa-flag-checkered"></i> Selesai</a>

                <a type="button" href="/admin-penarikan-point" target="___blank" class="btn btn-info btn-lg btn3d text-decoration-none" style="color:aliceblue;"><span class="glyphicon glyphicon-remove"></span><i class="fa-sharp fa-solid fa-money-check-dollar"></i> Penarikan Point</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    {{-- Modal daftar pengumuman --}}
    <div class="modal fade" id="daftarPengumuman" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Semua postingan

              <form action="{{ route('dashboard') }}" method="GET" class="search_div needs-validation" novalidate>
                <div class="input-group mb-1">
                  <input type="hidden" name="announcement_hide" value="?">
                  <input type="text" class="form-control bg-light border border-dark" placeholder="Cari disini..." name="search_pengumuman" value="{{ request('search_pengumuman') }}" autocomplete="off">
                  <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>
            </h1>
            
            <button type="button" class="pengumuman_close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @if ($announcements->count())
                @foreach ($announcements as $pengumuman)
                <ul class="list-group mb-4 btn3d text-center">
                  <li class="list-group-item bg-warning">{{ $pengumuman->judul }}</li>
                  <li class="list-group-item">
                    @if ($pengumuman->category_id == 0 )
                        Pengumuman biasa (tidak ada kategori).
                      @else
                      {{ $pengumuman->category->category_name }}.
                    @endif
                  </li>
                  <li class="list-group-item">{{ $pengumuman->pesan }}.</li>
                  <li class="list-group-item">
                    @if ($pengumuman->exam_design && Storage::disk('public')->exists($pengumuman->exam_design))
                    <img src="{{ asset('storage/' . $pengumuman->exam_design) }}" alt="" class="img-fluid" style="width: 150px; height:100px; object-fit:cover;">
                    @else
                    <img src="/imgs/kentang.jpg" alt="" class="img-fluid" style="width: 150px; height:100px; object-fit:cover;">
                    @endif
                  </li>
                  <li class="list-group-item">{{ $pengumuman->durasi }} Hari. <br> 
                    @if ($pengumuman->tanggal_expired < $date_now)
                       <span class="text-danger">Sudah Expired</span>
                      @else
                        @if ($pengumuman->tanggal_expired->diffInDays() >= 1)
                         <span class="text-muted">Partisipasi tersisa {{ $pengumuman->tanggal_expired->diffInDays() }} hari lagi.</span>
                        @else
                        <span class="text-muted">Partisipasi tersisa {{ $pengumuman->tanggal_expired->diffInHours() }} jam lagi.</span>
                        @endif
                    @endif
                    
                  </li>
                  <li class="list-group-item">
                    @if ($pengumuman->user_id == 0)
                        {{ $pengumuman->nama_admin }}
                    @else 
                        {{ $pengumuman->user->nama }}
                    @endif
                  </li>
                  <li class="list-group-item d-flex justify-content-center">
                    <a href="/all-design/{{ $pengumuman->id }}" target="___blank" type="button" class="button text-decoration-none me-3"><span><i class="fa-sharp fa-solid fa-shirt"></i></span></a>
                    @if ($pengumuman->publikasi_voting == false)
                    <form action="{{ route('dashboard') }}" method="GET" class="me-3">
                      <input type="hidden" name="update_announcement" value="{{ $pengumuman->slug_id }}">
                      <button type="submit" class="button"><span><i class="fa-sharp fa-solid fa-file-pen"></i></span></button>
                    </form>
                    @endif
                    <form action="{{ route('announcements.destroy' , $pengumuman->slug_id) }}" method="POST" class="me-3" id="peng_des{{ $pengumuman->id }}">
                      @method('delete')
                      @csrf
                      <button type="button" class="button" id="btnPengDes{{ $pengumuman->id }}"><span><i class="fa-sharp fa-solid fa-trash"></i></span></button>

                      <script>
                        $(document).ready(function(){
                          $('#btnPengDes{{ $pengumuman->id }}').click(function(){
                                Swal.fire({
                                            title: 'Hapus Pengumuman?',
                                            text: "Pastikan pengumuman sudah tidak digunakan!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Hapus!'
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                               $('#peng_des{{ $pengumuman->id }}').trigger('submit')
                                            }
                                            })
                              })
                        })
                      </script>

                    </form>
                    @if ($pengumuman->publikasi_voting == false && $pengumuman->exam_design)
                    <form action="{{ route('dashboard') }}" method="GET" class="">
                      <input type="hidden" name="announcement_id" value="{{ $pengumuman->slug_id }}">
                      <button type="submit" class="button"><span><i class="fa-sharp fa-solid fa-hand-point-up"></i></span></button>
                    </form>
                    @endif
                  </li>
                 
                </ul>
                @endforeach

                <div id="paginator" class="d-flex justify-content-center flex-wrap">
                  {{ $announcements->appends(['search_pengumuman' => request('search_pengumuman') , 'announcement_id' => request('announcement_id')])->onEachSide(1)->links() }}
                </div>
                @else
                <strong class="text-danger d-flex justify-content-center">Woops data yang kamu cari tidak ditemukan.</strong>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="pengumuman_close btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- ############# --}}

    {{-- Modal daftar voting --}}
    <div class="modal fade" id="daftarVoting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Semua post voting
            
              <form action="{{ route('dashboard') }}" method="GET" class="search_div needs-validation" novalidate>
                <div class="input-group mb-1">
                  <input type="hidden" name="voting_hide" value="?">
                  <input type="text" class="form-control bg-light border border-dark" placeholder="Cari disini..." name="search_voting" value="{{ request('search_voting') }}">
                  <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @if ($votings->count())
                @foreach ($votings as $voting)
                <ul class="list-group mb-4 btn3d text-center">
                  <li class="list-group-item bg-warning">{{ $voting->judul_voting }}.</li>
                  <li class="list-group-item">
                    @if ($voting->category_id == 0 )
                    Voting biasa (tidak ada kategori).
                      @else
                      {{ $voting->category->category_name }}.
                    @endif
                  </li>
                  <li class="list-group-item">{{ $voting->pesan_voting }}</li>
                  <li class="list-group-item">
                    @if ($voting->exam_design)
                    <img src="{{ asset('storage/' . $voting->exam_design) }}" alt="" class="img-fluid" style="width: 150px; height:100px; object-fit:cover;">
                    @else
                    <img src="/imgs/kentang.jpg" alt="" class="img-fluid" style="width: 150px; height:100px; object-fit:cover;">
                    @endif
                  </li>
                  <li class="list-group-item">{{ $voting->durasi_voting }} Hari. <br> 
                    @if ($voting->tanggal_expired < $date_now)
                    <span class="text-danger">Sudah Expired</span>
                   @else
                     @if ($voting->tanggal_expired->diffInDays() >= 1)
                      <span class="text-muted">Partisipasi tersisa {{ $voting->tanggal_expired->diffInDays() }} hari lagi.</span>
                     @else
                     <span class="text-muted">Partisipasi tersisa {{ $voting->tanggal_expired->diffInHours() }} jam lagi.</span>
                     @endif
                 @endif
                  </li>
                  <li class="list-group-item">
                    @if ($voting->user_id == 0)
                        {{ $voting->nama_admin }}
                    @else 
                        {{ $voting->user->nama }}
                    @endif
                  </li>
                  <li class="list-group-item d-flex justify-content-center">
                    <form action="/all-vote-design/{{ $voting->announcement_id }}" method="GET"  target="___blank" class="me-3">
                      <input type="hidden" name="voting_exp" value="{{ $voting->tanggal_expired }}" class="d-none" readonly required>
                      <button type="submit" class="button"><span><i class="fa-sharp fa-solid fa-shirt"></i></span></button>
                    </form>
                  
                    <form action="{{ route('dashboard') }}" method="GET" class="me-3">
                      <input type="hidden" name="voting_update" class="d-none" value="{{ $voting->slug_id }}">
                      <button class="button"><span><i class="fa-sharp fa-solid fa-file-pen"></i></span></button>
                    </form>
                    <form action="{{ route('votings.destroy' , $voting->slug_id) }}" method="POST" id="vot_des{{ $voting->id }}">
                      @csrf
                      @method('delete')
                      <button class="button" type="button" id="btnVotDes{{ $voting->id }}"><span><i class="fa-sharp fa-solid fa-trash"></i></span></button>
                    </form>

                    <script>
                      $(document).ready(function(){
                        $('#btnVotDes{{ $voting->id }}').click(function(){
                              Swal.fire({
                                          title: 'Hapus Voting?',
                                          text: "Pastikan voting sudah tidak digunakan!",
                                          icon: 'warning',
                                          showCancelButton: true,
                                          confirmButtonColor: '#3085d6',
                                          cancelButtonColor: '#d33',
                                          confirmButtonText: 'Hapus!'
                                          }).then((result) => {
                                          if (result.isConfirmed) {
                                             $('#vot_des{{ $voting->id }}').trigger('submit')
                                          }
                                          })
                            })
                      })
                    </script>

                  </li>
                </ul>
                @endforeach

                <div id="paginator" class="d-flex justify-content-center flex-wrap">
                  {{ $votings->appends(['search_voting' => request('search_voting')])->onEachSide(1)->links() }}
                </div>
                @else
                <strong class="text-danger d-flex justify-content-center">Woops data yang kamu cari tidak ditemukan.</strong>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_user_close">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- ############# --}}

  
    <script>                           
            
      function previewImage()
   {
     const image = document.querySelector('#gmb');
     const imgPreview = document.querySelector('.img-preview');

     imgPreview.style.display = 'block';
    
   
     const blob = URL.createObjectURL(image.files[0]);
     imgPreview.src = blob;
   }

     </script>

<script>
   $(document).ready(function(){
    if({{ request('announcement_page') && !session('flash_error') || request('search_pengumuman') && !session('flash_error') || request('announcement_hide') && !session('flash_error')  }}){
      $('#btn_pengumuman').trigger('click')
    }

   });
</script>
    

<script>
     $(document).ready(function(){
    if({{ request('voting_page') && !session('flash_error') || request('search_voting') && !session('flash_error') || request('voting_hide') && !session('flash_error')  }}){
      $('#btn_voting').trigger('click');
    }

   })
</script>



  <!-- Footer-->
  <div style="margin-top:250px;">
    @include('components.footer')
  </div>

@endsection