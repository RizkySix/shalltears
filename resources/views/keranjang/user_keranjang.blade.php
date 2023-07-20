@extends('components.conten_main')

@section('css')
    <link rel="stylesheet" href="/css/selling_view.css">
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <form action="/keranjang-confirmation" method="GET" id="submit_form" class="needs-validation" novalidate>

            <div class="col-sm-12 mb-4 d-flex">
              @if (session()->has('success'))
              <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              
              @endif
                <button type="button" class="button" id="mdl" data-bs-toggle="modal" ><span>Bayar Sekarang</span></button>

                
            </div>
               <hr style="color:aliceblue">
      
               <div class="col-sm-12 d-flex flex-wrap">
                @if ($keranjangs->count())
                @php
                    $idx = 0;
                @endphp
                @foreach ($keranjangs as $produks)

                    @foreach ($produks->selling_produks as $produk)
                    <div class="col-sm-4 mb-4 mt-4 d-flex justify-content-center" style="flex-grow: 1;">
                         <div class="card" style="width: 24rem; height:100%;">
                              <div id="carousel{{ $idx }}{{ $produk->id }}" class="carousel slide">
                                   <div class="carousel-indicators">                              
                                 
                                        @php
                                        //definisikan variabel untuk menampung total produk_image yang memiliki data gambar
                                            $totalGambar = 0;
                                        @endphp

                                        @for($i = 1; $i <= 8; $i++)
                                    
                                          @php
                                          //setelah dilakukan looping sesuai dengan total colum produk_image yaitu 8 kita buat variable yang berisi nama dari masing-masing column produk_image
                                           $produk_image = $produk['produk_image' . $i];
                                         @endphp

                                          @if ($produk_image)
                                            @if($totalGambar == 0)
                                              <button type="button" data-bs-target="#carousel{{ $idx }}{{ $produk->id }}" data-bs-slide-to="{{ $totalGambar }}" class="active" aria-current="true" ></button>
                                           @else
                                           
                                           {{-- kemudian data-bs-slide-target akan diarahkan secara berurutan, jika misalnya $produk_image7 tidak berisi data gambar maka data-bs-slide-target untuk nomor 7 akan di skip dan langsung diarahkan ke nomor berikutnya --}}

                                          <button type="button" data-bs-target="#carousel{{ $idx }}{{ $produk->id }}" data-bs-slide-to="{{ $totalGambar }}"></button>
                                          @endif

                                          @php
                                          //jika $produk_image berisi data gambar atau tidak kosong maka nilai $totalGambar akan ditambah
                                              $totalGambar++;
                                          @endphp

                                         @endif
                                      @endfor

                                   </div>

                                   <div class="carousel-inner">
                                    <div class="carousel-item active">

                                      <img src="{{ asset('storage/' . $produk->produk_image1) }}" style="width:250px; height:250px; object-fit:cover;" class="img-fluid d-block w-100" alt="...">
                                      <div class="carousel-caption d-none d-md-block">
                                      
                                      </div>
                                    </div>
                                    @if ($produk->produk_image2)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image2) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image3)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image3) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image4)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image4) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image5)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image5) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image6)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image6) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image7)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image7) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image8)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image8) }}" style="width:250px; height:250px; object-fit:cover;" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                 
                                    
                                  </div>
                                   
                                   <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $idx }}{{ $produk->id }}" data-bs-slide="prev">
                                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Previous</span>
                                   </button>
                                   <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $idx }}{{ $produk->id }}" data-bs-slide="next">
                                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Next</span>
                                   </button>
                                 </div>
                                 <div class="d-flex">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                      </div>
                                      
                                      @foreach ($produk->cutting_produks as $cutting)
                                          @if ($cutting->pivot->cutting_produks_id == $produks->cutting_produk_id)
                                            @if ($cutting->pivot->stok_produk < $produks->qty)
                                            <div class="d-flex align-items-center me-3">
                                              <input type="checkbox" name="items[]" class="form-check-input" value="{{ $produks->id }}" disabled>
                                            </div>
                                            @else
                                            <div class="d-flex align-items-center me-3">
                                              <input type="checkbox" name="items[]" class="form-check-input" value="{{ $produks->id }}">
                                            </div>
                                            @endif
                                          @endif
                                      @endforeach

                                 </div>
                              <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item">{{ $produk->category->category_name }} ({{ $produk->warna_produk }})</li>
                                <li class="list-group-item" style="padding:20px 0px;">
                                    
                                   <span>{{ $produks->cutting->cutting_name }} <span class="text-muted">({{ $produks->qty }})</span></span>
                                </li>
                                <li class="list-group-item">
                                  @if ($produk->diskon_id && $produk->diskon->status_aktif == true)
                                  <div class="d-flex flex-column flex-wrap justify-content-center m-auto">
                                    <span class="fw-bold bg-warning rounded w-75 m-auto" style="padding:10px;">{{ $produk->diskon->nama_diskon }} ({{ $produk->diskon->persen_diskon }}%)</span>

                                    <strike>
                                      <span class="text-muted">Harga : Rp. {{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}</span>
                                    </strike>

                                    @php
                                        $persenDiskon = $produk->diskon->persen_diskon/100;
                                        $hargaDiskon = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
                                    @endphp
                                      <span class="mb-3">Harga : Rp. {{ str_replace(',' , '.' , number_format($hargaDiskon)) }}</span>

                                      @if ($produk->diskon->tanggal_selesai->diffInDays() >= 1)
                                       <span class="text-muted">Diskon berlangsung selama {{ $produk->diskon->tanggal_selesai->diffInDays() }} hari lagi.</span>
                                    @else
                                        <span class="text-muted">Diskon berlangsung selama {{ $produk->diskon->tanggal_selesai->diffInHours() }} jam lagi.</span>
                                    @endif
                                  </div>
                                  @else
                                    <span>Harga : Rp. {{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}</span>
                                  @endif
                              </li>

                                {{-- Modal konfirmasi pesanan --}}
                                <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Pembayaran</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="#" method="GET" class="needs-validation" novalidate>
                                      <div class="modal-body text-start">
                                    
                                          <label for="pemesan" class="form-label mt-3">Nama Anda</label>
                                          <input type="text" id="pemesan" class="form-control" name="pemesan"  required>
                  
                                          <label for="alamat" class="form-label mt-3">Alamat Lengkap</label>
                                          <input type="text" id="alamat" class="form-control" name="alamat"  placeholder="Jl.Baturiti Kerambitan, No 981" required>
                  
                                          <label for="no_hp" class="form-label mt-3">No.Hp</label>
                                          <input type="text" id="no_hp" class="form-control format_number" name="no_hp" required>
                  
                                    
                                      </div>
                                      <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" id="pay-button">Lanjut</button>
                                      </div>
                                    </form>
                                  </div>
                                  </div>
                              </div>
                              </form>

                                <div class="card-footer d-flex justify-content-around">
                                <div>
                                  <button class="button mt-2" type="button" data-bs-toggle="modal" data-bs-target="#size_change{{ $idx }}{{ $produk->id }}" ><span>Ganti size</span></button>
                                </div>
                                 <div>
                                  <form action="/delete-keranjang/{{ $produks->id }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="button mt-2" type="submit" ><span>Hapus</span></button>
                                  </form>
                                 </div>
                                </div>
                                
                                 
                           
                            

                              {{-- Modal ganti size  --}}
                              <div class="modal fade" id="size_change{{ $idx }}{{ $produk->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Rubah Size</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/update-keranjang/{{ $produks->id }}" method="POST" class="needs-validation" novalidate>
                                      @csrf
                                      @method('put')
                                    <div class="modal-body">
                                  
                                      <div class="d-flex flex-wrap justify-content-center mt-4">
                                        @foreach ($produk->cutting_produks as $cutting)
                                        @if ($cutting->pivot->stok_produk != 0)
                                             <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer; background-color:ghostwhite;" class="c_size" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="rad_keranjang{{ $idx }}{{ $cutting->id }}">{{ $cutting->cutting_name }}</label>
                                        @else
                                           <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer;" class="c_size bg-danger" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="sold_keranjang">{{ $cutting->cutting_name }}</label>
                                        @endif
                                        <input type="radio" name="size_keranjang" id="rad_keranjang{{ $idx }}{{ $cutting->id }}" class="rad2 therad{{ $idx }} form-check-control d-none" value="{{ $cutting->id }}" required data-max="{{ $cutting->pivot->stok_produk }}">
                                        @endforeach

                                      </div>
                                        
                                    <div class="mt-3">
                                       <div class="d-flex justify-content-center ">
                                        <input type="number" name="qty_keranjang" class="qty-input-krj form-control w-50" placeholder="Qty" id="qty_keranjang" required>
                                       </div>
                                      
                                    </div>

                                    <script>
                                        /* code ini berasal dari chatGpt keyword manipulasi nilai max input berdasarkan value yang ditentukan (copas code semua biar langsung dapat jawaban) */
                                        $(document).ready(function(){
                                            $(document).ready(function() {
                                                $('.rad2').change(function() {
                                                    if ($(this).is(':checked')) {
                                                    // Radio button dipilih
                                                    var maxQty = $(this).data('max');
                                                    $('.qty-input-krj').attr('max', maxQty);
                                                    }
                                                });
                                                });
                                        });
                                       </script>

                                          <script>
                                            $(document).ready(function(){
                                            $('.c_size').tooltip();
                                            });
                                          </script>
                
                                  
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn btn-primary" >Lanjut</button>
                                    </div>
                                </form>

                                <script>
                                  $(document).ready(function() {
                                   // Deteksi saat checkbox di klik
                                   $('.therad{{ $idx }}').click(function() {
                                     if ($('.therad{{ $idx }}:checked').length > 0) {
                                       // Jika ada checkbox yang dipilih, set nilai data-bs-target menjadi #modal
                                       $('#mdl').attr('type', 'button');
                                     } else {
                                       // Jika tidak ada checkbox yang dipilih, hapus nilai data-bs-target
                                       $('#mdl').removeAttr('type');
                                     }
                                   });
                                 });
                     
                                 </script>

                                </div>
                                </div>
                            </div>
                         
                            </div>
                    </div>
                                    
                 @endforeach
                    @php
                        $idx++
                    @endphp
                    @endforeach
                    @else
                    <div class=" d-flex justify-content-center align-items-center flex-column ms-auto me-auto" style="margin-top:150px; ">
                      <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                      <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                  </div>
                @endif
                   
               </div>


            <script>
             $(document).ready(function() {
              // Deteksi saat checkbox di klik
              $('input[type="checkbox"]').click(function() {
                if ($('input[type="checkbox"]:checked').length > 0) {
                  // Jika ada checkbox yang dipilih, set nilai data-bs-target menjadi #modal
                  $('#mdl').attr('data-bs-target', '#modal');
                } else {
                  // Jika tidak ada checkbox yang dipilih, hapus nilai data-bs-target
                  $('#mdl').removeAttr('data-bs-target');
                }
              });
            });

            </script>
          
            
            <script>
                $('.format_number').keyup(function(event) {

                    // skip for arrow keys
                    if(event.which >= 37 && event.which <= 40) return;

                    // format number
                    $(this).val(function(index, value) {
                    return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, "-")
                    ;
                    });
                    });

                    const format_number =  document.querySelector(".format_number")
                    format_number.addEventListener("keypress", function (evt) {
                    if (evt.which < 48 || evt.which > 57)
                    {
                        evt.preventDefault();
                    }
                    });

            </script>

              <script>
                $(document).ready(function(){
                $('.c_size').tooltip();
                $('.c_size').click(function(){
                    $(this).css('background-color' , 'cyan');
                    $('.c_size').not(this).css('background-color' , 'ghostwhite');
                })
                });
              </script>

        </div>
    </div>
@endsection
