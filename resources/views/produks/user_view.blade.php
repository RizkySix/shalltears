@extends('components.conten_main')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">
<style>
   .list-group-item{
    padding: 15px 0px;
   }


   .bg-yellow {
    background-color: yellow;
  }

  .labelcat:hover{
    background-color: aliceblue;
  }
</style>
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

                <div class="col-sm-12 mb-4 d-flex">
                    <button type="button" class=" btn btn-primary btn3d" style="color:aliceblue; margin-right:10px;" data-bs-toggle="modal" data-bs-target="#categoryMDL">Category</button>
                    <form action="/user-product" method="GET">
                        <button type="submit" name="terlaris" value="laris" class=" btn btn-warning btn3d" style="color:aliceblue; margin-right:10px;" >Terlaris</button>
                    </form>
                    <form action="/user-product" method="GET">
                        <button type="submit" name="diskon" value="diskon" class=" btn btn-danger btn3d" style="color:aliceblue; margin-right:10px;" >Promo Diskon</button>
                    </form>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="categoryMDL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($categories->count())
                               <form action="/user-product" method="GET">
                                   <div class="d-flex justify-content-center w-75 m-auto">
                                    @foreach ($categories as $category)
                                        
                                    <label for="{{ $category->id }}" class="labelcat btn btn-info btn3d me-3">{{ $category->category_name }}</label>
                                    <input type="submit" name="filter_category" id="{{ $category->id }}" value="{{ $category->id }}" readonly class="d-none">
                                @endforeach
                                   </div>
                                
                                </form>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>

                   <hr style="color:aliceblue" class="mb-4">
                
               <div class="col-sm-12 d-flex flex-wrap flex-column justify-content-center">
                <div class="conteudo">
                    @if ($produks->count())
                    @php
                     $idx = 0;
                    @endphp
                        @foreach ($produks as $produk)
                       
                        <div class="carrosel m-auto">
                            @if ($produk->produk_image1)
                                <div class="caixa__card cc__1">
                                    <a href="{{ asset('storage/' . $produk->produk_image1) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image1) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif
                            @if ($produk->produk_image2)
                                <div class="caixa__card cc__2">
                                    <a href="{{ asset('storage/' . $produk->produk_image2) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image2) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif

                            @if ($produk->produk_image3)
                                <div class="caixa__card cc__3">
                                    <a href="{{ asset('storage/' . $produk->produk_image3) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image3) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif

                            @if ($produk->produk_image4)
                                <div class="caixa__card cc__4">
                                    <a href="{{ asset('storage/' . $produk->produk_image4) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image4) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif
                            

                            @if ($produk->produk_image5)
                                <div class="caixa__card cc__5">
                                    <a href="{{ asset('storage/' . $produk->produk_image5) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image5) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif

                            @if ($produk->produk_image6)
                                <div class="caixa__card cc__6">
                                    <a href="{{ asset('storage/' . $produk->produk_image6) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image6) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif

                            @if ($produk->produk_image7)
                                <div class="caixa__card cc__7">
                                    <a href="{{ asset('storage/' . $produk->produk_image7) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image7) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif

                            @if ($produk->produk_image8)
                                <div class="caixa__card cc__8">
                                    <a href="{{ asset('storage/' . $produk->produk_image8) }}"  style="height:100%; width: 100%;" data-lightbox="{{ $produk->nama_produk }}" data-title="{{ $produk->nama_produk }}">  <img src="{{ asset('storage/' . $produk->produk_image8) }}"   style="height:100%; width: 100%;  border-radius: 8px; object-fit:cover;"></a>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 25rem; margin-top:50px; margin-right:8%;">
                                <ul class="list-group list-group-flush text-center">
                                  <li class="list-group-item"><h5>{{ $produk->nama_produk }}</h5></li>
                                  <li class="list-group-item"><span>{{ $produk->category->category_name }} <span class="text-muted">({{ $produk->warna_produk }})</span></span></li>
                                  <li class="list-group-item">
                                    <div class="d-flex flex-wrap justify-content-center">
                                        @foreach ($produk->cutting_produks as $cutting)
                                        @if ($cutting->pivot->stok_produk != 0)
                                            <span style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer; background-color:ghostwhite;" class="size" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}">{{ $cutting->cutting_name }}</span>
                                        @else
                                             <span style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer;" class="size bg-danger" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}">{{ $cutting->cutting_name }}</span>
                                        @endif

                                        @endforeach
                                      </div>

                                      <script>
                                        $(document).ready(function(){
                                           $('.size').tooltip();
                                         });
                                     </script>
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
                                <div class="card-body text-center ">
                                    <p id="excerpt{{ $produk->id }}" style="display:block;">{!! Str::limit($produk->deskripsi_produk, 50, '....') !!}</p>
                                    <p id="full-text{{ $produk->id }}" style="display:none;">{!! $produk->deskripsi_produk !!}</p>
                                    <a href="#" id="read-more{{ $produk->id }}" class=" text-decoration-none">Lebih banyak...</a>
                                    <a href="#" id="normal-text{{ $produk->id }}" class=" text-decoration-none" style="display:none;">Sedikit...</a>

                                    <script>
                                        $(document).ready(function() {
                                           $('#read-more{{ $produk->id }}').on('click', function(e) {
                                             e.preventDefault();
                                             $(this).css('display' , 'none');
                                             $('#excerpt{{ $produk->id }}').css('display' , 'none');
                                             $('#full-text{{ $produk->id }}').css('display' , 'block');
                                             $('#normal-text{{ $produk->id }}').css('display' , 'block');
         
                                             $('#normal-text{{ $produk->id }}').on('click' , function(evt){
                                               evt.preventDefault();
                                               $(this).css('display' , 'none');
                                               $('#excerpt{{ $produk->id }}').css('display' , 'block');
                                               $('#full-text{{ $produk->id }}').css('display' , 'none');
                                               $('#read-more{{ $produk->id }}').css('display' , 'block');
         
                                             })
                                           });
                                         });
                                       </script>
                                </div>
                                <hr style="color:gray;">
                                <li class="list-group-item">
                                   @if ($produk->user)
                                   <span>
                                    Design by : {{ $produk->user->nama }}
                                  </span>
                                  @else
                                  Design by : Admin
                                   @endif
                                    <br>
                                  <span class="text-muted"> {{ $produk->terjual }} Terjual</span>
                                </li>

                                <div class="list-group list-group-flush mb-3">
                                   @can('cust_design')

                                    <div class="d-flex justify-content-around mt-3">

                                        <button class="button" data-bs-toggle="modal" data-bs-target="#keranjang{{ $produk->id }}"><span>Keranjang</span></button>
                                        <button class="button" data-bs-toggle="modal" data-bs-target="#modal{{ $produk->id }}"><span>Pesan</span></button>
                                    
                                        </div>
                                   @endcan

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $produk->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Pesan Produk</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/show-product" method="GET" class="needs-validation" novalidate>
                                            <div class="modal-body">
                                          
                                                <div class="col-sm-8 m-auto text-start">
                                                    <label for="nama_produk" class="form-label">Nama produk.</label>
                                                    <input type="text" id="nama_produk" class="form-control" name="nama_produk" value="{{ $produk->nama_produk }}" required readonly>

                                                    <label for="category_produk" class="form-label mt-3">Category</label>
                                                    <input type="text" id="category_produk" class="form-control" name="category_produk" value="{{ $produk->category->category_name }}" required readonly>

                                                    <label for="warna" class="form-label mt-3">Warna</label>
                                                    <input type="text" id="warna" class="form-control" name="warna" value="{{ $produk->warna_produk }}" required readonly>

                                                    <label for="produk_id" class="form-label mt-3 d-none">produk_id</label>
                                                    <input type="hidden" id="produk_id" class="form-control d-none" name="produk_id" value="{{ $produk->id }}" required readonly>

                                
                                                    @if ($produk->diskon_id && $produk->diskon->status_aktif == true)
                                                    <label for="harga" class="form-label mt-3">Harga/pcs</label>
                                                    (<strike>
                                                        <span class="text-muted">Rp. {{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}</span>
                                                      </strike>)
                                                    <input type="text" id="harga" class="form-control" name="harga" value="{{ str_replace(',' , '.' , number_format($hargaDiskon)) }}" required readonly>
                                                 
                                                    @else
                                                    <label for="harga" class="form-label mt-3">Harga/pcs</label>
                                                    <input type="text" id="harga" class="form-control" name="harga" value="{{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}" required readonly>
                                                    @endif

                                

                                                    <div class="d-flex flex-wrap justify-content-center mt-4">
                                                        @foreach ($produk->cutting_produks as $cutting)
                                                        @if ($cutting->pivot->stok_produk != 0)
                                                             <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer; background-color:ghostwhite;" class="c_size" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="rad{{ $idx }}{{ $cutting->id }}">{{ $cutting->cutting_name }}</label>
                                                        @else
                                                           <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer;" class="noc_size bg-danger" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="sold">{{ $cutting->cutting_name }}</label>
                                                        @endif
                                                        <input type="radio" name="cutting_id" id="rad{{ $idx }}{{ $cutting->id }}" class="rad1 form-check-control d-none" value="{{ $cutting->id }}" required data-max="{{ $cutting->pivot->stok_produk }}">

                                                        @endforeach

                                                    
                                                      </div>
                                                        
                                                    <div class="mt-3">
                                                       <div class="d-flex justify-content-center ">
                                                        <input type="number" name="qty" class="qty-input form-control w-50" placeholder="Qty" id="qty" required>
                                                       </div>
                                                      
                                                    </div>
                                                  
                                                    <script>
                                                        /* code ini berasal dari chatGpt keyword manipulasi nilai max input berdasarkan value yang ditentukan (copas code semua biar langsung dapat jawaban) */
                                                        $(document).ready(function() {
                                                                $('.rad1').change(function() {
                                                                    if ($(this).is(':checked')) {
                                                                    // Radio button dipilih
                                                                    var maxQty = $(this).data('max');
                                                                    $('.qty-input').attr('max', maxQty);
                                                                    }
                                                                });

                                                
                                                        });
                                                       </script>
                                                  
                                                     
                                                     <label for="pemesan" class="form-label mt-3">Nama Anda</label>
                                                     <input type="text" id="pemesan" class="form-control" name="pemesan"  required>

                                                     <label for="alamat" class="form-label mt-3">Alamat Lengkap</label>
                                                     <input type="text" id="alamat" class="form-control" name="alamat"  placeholder="Jl.Baturiti Kerambitan, No 981" required>

                                                     <label for="no_hp" class="form-label mt-3">No.Hp</label>
                                                     <input type="text" id="no_hp" class="form-control format_number" name="no_hp" required>
 
                                                </div>

                                          
                                            </div>
                                            <div class="modal-footer">
                                         
                                            <button type="submit" class="btn btn-primary">Lanjut</button>
                                            </div>
                                        </form>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="keranjang{{ $produk->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ke Keranjang</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/user-keranjang" method="POST" class="needs-validation" novalidate>
                                            @csrf
                                            <div class="modal-body">
                                          
                                                <div class="col-sm-8 m-auto text-start">
                                                  
                                                    <input type="hidden" id="keranjang_produk_id" class="form-control d-none" name="keranjang_produk_id" value="{{ $produk->id }}" required readonly>


                                                    <div class="d-flex flex-wrap justify-content-center mt-4">
                                                        @foreach ($produk->cutting_produks as $cutting)
                                                        @if ($cutting->pivot->stok_produk != 0)
                                                             <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer; background-color:ghostwhite;" class="c_size" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="rad_keranjang{{ $idx }}{{ $cutting->id }}">{{ $cutting->cutting_name }}</label>
                                                        @else
                                                           <label style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer;" class="noc_size bg-danger" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}" for="sold_keranjang">{{ $cutting->cutting_name }}</label>
                                                        @endif
                                                        <input type="radio" name="size_keranjang" id="rad_keranjang{{ $idx }}{{ $cutting->id }}" class="rad2 form-check-control d-none" value="{{ $cutting->id }}" required data-max="{{ $cutting->pivot->stok_produk }}">
                                                     
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
                                                  

                                                </div>

                                          
                                            </div>
                                            <div class="modal-footer">
                                         
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </form>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                </ul>
                              </div>
                        </div>
                        <br><br><br><br>
                        @php
                        $idx++;
                    @endphp
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $produks->links() }}
                        </div>
                        @else
                        <div class="d-flex justify-content-center align-items-center flex-column" style="margin-top:200px;">
                            <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                            <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                        </div>

                    @endif
                        
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
        </div>
    </div>
    </div>

  
@endsection