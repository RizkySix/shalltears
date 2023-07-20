@extends('components.conten_main')

@section('css')
    <link rel="stylesheet" href="/css/selling_view.css">
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12 mb-4">
              <a href="/selling_produks" class="text-decoration-none btn btn-warning btn3d" style="color:aliceblue;">Produk on publish</a>
                @if (session()->has('success'))
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @endif
            </div>
               <hr style="color:aliceblue">
      
               <div class="col-sm-12 d-flex flex-wrap">
                @if($produks->count())
                    @foreach ($produks as $produk)
                    <div class="col-sm-4 mb-4 mt-4 d-flex justify-content-center" style="flex-grow: 1;">
                         <div class="card" style="width: 24rem; height:100%;">
                              <div id="carousel{{ $produk->id }}" class="carousel slide">
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
                                              <button type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide-to="{{ $totalGambar }}" class="active" aria-current="true" ></button>
                                           @else
                                           
                                           {{-- kemudian data-bs-slide-target akan diarahkan secara berurutan, jika misalnya $produk_image7 tidak berisi data gambar maka data-bs-slide-target untuk nomor 7 akan di skip dan langsung diarahkan ke nomor berikutnya --}}

                                          <button type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide-to="{{ $totalGambar }}"></button>
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

                                      <img src="{{ asset('storage/' . $produk->produk_image1) }}" style="width:250px; height:250px; object-fit:cover" class="img-fluid d-block w-100" alt="...">
                                      <div class="carousel-caption d-none d-md-block">
                                      
                                      </div>
                                    </div>
                                    @if ($produk->produk_image2)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image2) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image3)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image3) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image4)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image4) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image5)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image5) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image6)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image6) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image7)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image7) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                    @if ($produk->produk_image8)
                                    <div class="carousel-item">
                                       <img src="{{ asset('storage/' . $produk->produk_image8) }}" style="width:250px; height:250px; object-fit:cover" class="d-block w-100" alt="...">
                                       <div class="carousel-caption d-none d-md-block">
                                    
                                       </div>
                                     </div>
                                    @endif
                                 
                                    
                                  </div>
                                   
                                   <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide="prev">
                                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Previous</span>
                                   </button>
                                   <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide="next">
                                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Next</span>
                                   </button>
                                 </div>
                              <div class="card-body text-center">
                                <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                              </div>
                              <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item">{{ $produk->category->category_name }} ({{ $produk->warna_produk }})</li>
                                <li class="list-group-item" style="padding:20px 0px;">
                                 
                                        <div class="d-flex flex-wrap justify-content-center">
                                          @foreach ($produk->cutting_produks as $cutting)
                                           <span style="border: 2px solid black; padding:5px 10px; margin-right:8px; cursor:pointer; background-color:ghostwhite;" class="size" data-toggle="tooltip" data-placement="top" title="Stok : {{ $cutting->pivot->stok_produk }}">{{ $cutting->cutting_name }}</span>

                                          @endforeach
                                        </div>

                                        <script>
                                          $(document).ready(function(){
                                             $('.size').tooltip();
                                           });
                                       </script>
                               
                                </li>
                                <li class="list-group-item">
                                  @if (!$produk->diskon_id)
                                   <span>Harga : Rp. {{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}</span>
                                  @else
                                    <div class="d-flex flex-column flex-wrap justify-content-center m-auto">
                                      <span class="fw-bold bg-warning rounded w-75 m-auto" style="padding:10px;">{{ $produk->diskon->nama_diskon }} ({{ $produk->diskon->persen_diskon }}%)</span>

                                      <strike>
                                        <span class="text-muted">Harga : Rp. {{ str_replace(',' , '.' , number_format($produk->harga_produk)) }}</span>
                                      </strike>

                                      @php
                                          $persenDiskon = $produk->diskon->persen_diskon/100;
                                          $hargaDiskon = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
                                      @endphp
                                        <span>Harga : Rp. {{ str_replace(',' , '.' , number_format($hargaDiskon)) }}</span>
                                    </div>
                                  @endif
                              </li>
                                 
                              </ul>
                              <div class="card-body text-center">
                                  <p id="excerpt{{ $produk->id }}" style="display:block;">{!! Str::limit($produk->deskripsi_produk, 50, '....') !!}</p>
                                  <p id="full-text{{ $produk->id }}" style="display:none;">{!! $produk->deskripsi_produk !!}</p>
                                  <a href="#" id="read-more{{ $produk->id }}" class=" text-decoration-none">Lebih banyak...</a>
                                  <a href="#" id="normal-text{{ $produk->id }}" class=" text-decoration-none" style="display:none;">Sedikit...</a>
                              </div>

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

                              <div class="list-group list-group-flush ">
                                  <div class="d-flex justify-content-around mt-3">
                                  <form action="{{ route('selling_produks.edit' , $produk->slug_id , 'edit') }}" method="GET">
                                    <button class="button"><span><i class="fa-sharp fa-solid fa-file-pen"></i></span></button>
                                  </form>
                                    <form action="{{ route('arsip_product' ,[ $produk->slug_id , 'publish']) }}" method="POST">
                                      @method('put')
                                      @csrf
                                      <button class="button"><span><i class="fa-sharp fa-solid fa-lock-open"></i></span></button>
                                    </form>
                                    <form action="{{ route('selling_produks.destroy' , $produk->slug_id) }}" method="POST" id="prod_del{{ $produk->id }}">
                                      @method('delete')
                                      @csrf
                                    <button class="button" type="button" id="btnProdDel{{ $produk->id }}"><span><i class="fa-sharp fa-solid fa-trash"></i></span></button>
                                  </form>

                                    <script>
                                      $(document).ready(function(){
                                        $('#btnProdDel{{ $produk->id }}').click(function(){
                                              Swal.fire({
                                                          title: 'Hapus Produk?',
                                                          text: "Pastikan produk tidak dalam status dipesan!",
                                                          icon: 'warning',
                                                          showCancelButton: true,
                                                          confirmButtonColor: '#3085d6',
                                                          cancelButtonColor: '#d33',
                                                          confirmButtonText: 'Hapus!'
                                                          }).then((result) => {
                                                          if (result.isConfirmed) {
                                                             $('#prod_del{{ $produk->id }}').trigger('submit')
                                                          }
                                                          })
                                            })
                                      })
                                    </script>
                                  </div>
                              </div>
                            </div>
                    </div>
                                    
                 @endforeach
                 @else
                 <div class="d-flex justify-content-center align-items-center flex-column me-auto ms-auto" style="margin-top:200px;">
                     <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                     <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                 </div>
                 @endif
               </div>
    
           
               
        </div>
    </div>
@endsection
