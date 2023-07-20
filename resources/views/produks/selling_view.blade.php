@extends('components.conten_main')

@section('css')
    <link rel="stylesheet" href="/css/selling_view.css">
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12 mb-4 d-flex">
                <a href="{{ route('selling_produks.create') }}" class="text-decoration-none btn btn-warning btn3d" style="color:aliceblue; margin-right:10px;">Buat produk</a>
                <a href="{{ route('view_arsip') }}" class="text-decoration-none btn btn-danger btn3d" style="color:aliceblue; margin-right:10px;">Produk diarsipkan</a>
                <button type="button" data-bs-toggle="modal" data-bs-target="#diskonToko" class="text-decoration-none btn btn-info btn3d" style="color:aliceblue;">Diskon Toko</button>

            <!-- Modal -->
            <div class="modal fade" id="diskonToko" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Promo Diskon Saat Ini</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex justify-content-center flex-wrap">
                     @if ($diskons->count())
                         @foreach ($diskons as $diskon)
                         <div class="card mt-4 me-3  bg-warning" style="position:relative;">
                          <span class=" fw-bold position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger" style="padding:10px; font-size:20px;">
                            {{ $diskon->persen_diskon }}%
                          </span>
                          <div class="card-body">
                            <div class="card-title text-center">
                              <span class="fw-bold" style="padding:20px;">{{ $diskon->nama_diskon }}</span>
                            </div>

                            <div class="d-flex text-center flex-column">
                              @if ($diskon->tanggal_mulai > $date_now)
                                <div>
                                    @php
                                    $parses = \Carbon\Carbon::parse($diskon->tanggal_mulai);
                                    $tanggal_mulai = $parses->format('d-M-Y');
                                    $jam_mulai = $parses->format('H:i:s');
                                  @endphp
                                  <span>Dimulai pada :</span> <br>
                                  <span>{{ $tanggal_mulai }}</span> pukul <span>{{ $jam_mulai }}</span>
                                </div>

                                <div class="mt-3">
                                  @php
                                  $parses = \Carbon\Carbon::parse($diskon->tanggal_selesai);
                                  $tanggal_selesai = $parses->format('d-M-Y');
                                  $jam_selesai = $parses->format('H:i:s');
                                @endphp
                                <span>Berakhir pada :</span> <br>
                                <span>{{ $tanggal_selesai }}</span> pukul <span>{{ $jam_selesai }}</span>
                              </div>
                              
                              @else
                              <div>
                                @php
                                  $parses = \Carbon\Carbon::parse($diskon->tanggal_selesai);
                                  $tanggal_selesai = $parses->format('d-M-Y');
                                  $jam_selesai = $parses->format('H:i:s');
                                @endphp
                                <span>Diskon aktif sampai :</span> <br>
                                <span>{{ $tanggal_selesai }}</span> pukul <span>{{ $jam_selesai }}</span>
                            </div>
                            
                            @endif
                            
                            <div class="mt-3">
                              @if ($diskon->selling_produk->count())
                              @foreach ($diskon->selling_produk as $getDisk)
                            
                              @if ($getDisk->diskon_id == $diskon->id)
                              <a href="#" data-toggle="tooltip" data-placement="top" title="
                              @foreach($diskon->selling_produk as $toolDisk)
                                {{ $toolDisk->nama_produk }},
                              @endforeach
                              "
                               class="toolproduk text-decoration-none" style="color:aliceblue; font-style:italic;">Lihat produk-produk yang menggunakan diskon ini</a>
  
                              @endif
                              @break
                             @endforeach

                             <script>
                              $(document).ready(function(){
                                 $('.toolproduk').tooltip();
                               });
                           </script>

                             @else
                             <a href="#" class="text-decoration-none" style="color:aliceblue; font-style:italic;">Belum ada produk yang menggunakan diskon ini</a>
                              @endif

                            </div>
                            
                            <hr>
                            <div class="d-flex justify-content-around">
                              <a class="btn btn-light text-decoration-none" href="/diskon-edit/{{ $diskon->id }}">Edit</a>
                              <form action="/aktif-nonaktif-diskon/{{ $diskon->id }}" method="POST" id="formStatus{{ $diskon->id }}">
                              @csrf
                              @method('put')
                                @if ($diskon->status_aktif == true && $diskon->tanggal_mulai <= $date_now)
                                <button type="button" class="btn btn-primary" id="buttonStatus{{ $diskon->id }}">Aktif</button>
                                @elseif($diskon->status_aktif == false && $diskon->tanggal_mulai <= $date_now)
                                <button type="submit" class="btn btn-info">Non-aktif</button>
                                @endif

                                <script>
                                  $(document).ready(function(){
                                    $('#buttonStatus{{ $diskon->id }}').click(function(){
                                          Swal.fire({
                                                      title: 'Yakin Nonaktifkan {{ $diskon->nama_diskon }}?',
                                                      text: "Menonaktifkan diskon secara tiba-tiba mungkin akan mempengaruhi loyalitas pelanggan! ",
                                                      icon: 'warning',
                                                      showCancelButton: true,
                                                      confirmButtonColor: '#3085d6',
                                                      cancelButtonColor: '#d33',
                                                      confirmButtonText: 'Nonaktif!'
                                                      }).then((result) => {
                                                      if (result.isConfirmed) {
                                                        $('#formStatus{{ $diskon->id }}').trigger('submit')
                                                      }
                                                      })
                                        })
                                  })
                                </script>

                              </form>
                              <form action="/delete-diskon/{{ $diskon->id }}" method="POST" id="deleteDiskon{{ $diskon->id }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="button" id="delButnDiskon{{ $diskon->id }}">Hapus</button>

                                <script>
                                  $(document).ready(function(){
                                    $('#delButnDiskon{{ $diskon->id }}').click(function(){
                                          Swal.fire({
                                                      title: 'Yakin Hapus {{ $diskon->nama_diskon }}?',
                                                      text: "Menghapus diskon sebelum tanggal selesai mungkin akan mempengaruhi loyalitas pelanggan! ",
                                                      icon: 'warning',
                                                      showCancelButton: true,
                                                      confirmButtonColor: '#3085d6',
                                                      cancelButtonColor: '#d33',
                                                      confirmButtonText: 'Hapus!'
                                                      }).then((result) => {
                                                      if (result.isConfirmed) {
                                                        $('#deleteDiskon{{ $diskon->id }}').trigger('submit')
                                                      }
                                                      })
                                        })
                                  })
                                </script>
                              </form>
                            </div>
                            </div>
                          </div>
                        </div>
                         @endforeach
                      @else
                      <div class="m-auto">
                        <span class="fw-bold">Belum ada diskon saat ini...</span>
                      </div>
                     @endif
                    </div>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ route('create.diskon') }}" class="text-decoration-none btn btn-warning btn3d" style="color:aliceblue;">Buat Promo Diskon</a>
                  </div>
                </div>
              </div>
            </div>
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
                  @php
                      $idx = 0;
                  @endphp
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
                                   
                                   <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide="prev">
                                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Previous</span>
                                   </button>
                                   <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $produk->id }}" data-bs-slide="next">
                                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                     <span class="visually-hidden">Next</span>
                                   </button>
                                 </div>
                              <div class="card-body text-center d-flex justify-content-center" style="position:relative;">
                               <div class="col-sm-11 ">
                                <h5 class="card-title w-75 m-auto">{{ $produk->nama_produk }}</h5>
                               </div>
                               @if (!$produk->diskon_id)
                               <button class="btn btn-warning rounded-circle position-absolute me-2 end-0" data-bs-toggle="modal" data-bs-target="#addDiskon{{ $produk->id }}" style="z-index: 999;"><i class="fa-sharp fa-solid fa-tag fa-lg"></i></button>

                              <!-- Modal -->
                              <div class="modal fade" id="addDiskon{{ $produk->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Diskon Untuk Produk</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="d-flex flex-column m-auto">
                                      
                                       @if ($diskons->count())
                                       @foreach ($diskons as $diskon)
                                       <form action="/tambah-produk-diskon" method="POST" id="diskon_submit{{ $idx }}{{ $diskon->id }}">
                                          <div class="input-group  mt-3 w-75 d-flex justify-content-center m-auto">
                                       
                                           @csrf
                                           @method('put')
                                          
                                           <span class="input-group-text bg-warning w-75" style="padding:10px;">
                                             <span class="rounded-circle me-4" style="border:2px solid black; padding:5px;"><i class="fa-sharp fa-solid fa-tag fa-lg"></i></span>
                                             <span class="fw-bold">{{ $diskon->nama_diskon }}</span>
                                           </span>
                                           <input type="hidden" name="diskon_id" class="d-none" value="{{ $diskon->id }}" readonly required>
                                           <input type="hidden" name="slug_produk" class="d-none" value="{{ $produk->slug_id }}" readonly required>
                                           <button type="button" class="btn btn-danger" id="prdDiskon{{ $idx }}{{ $diskon->id }}"><h5>+</h5></button>
                                        

                                                       
                                             <script>
                                               $(document).ready(function(){
                                                 $('#prdDiskon{{ $idx }}{{ $diskon->id }}').click(function(){
                                                       Swal.fire({
                                                                   title: 'Tambahkan ke {{ $diskon->nama_diskon }}?',
                                                                   text: "Harga normal produk akan berubah! ",
                                                                   icon: 'warning',
                                                                   showCancelButton: true,
                                                                   confirmButtonColor: '#3085d6',
                                                                   cancelButtonColor: '#d33',
                                                                   confirmButtonText: 'Tambah!'
                                                                   }).then((result) => {
                                                                   if (result.isConfirmed) {
                                                                     $('#diskon_submit{{ $idx }}{{ $diskon->id }}').trigger('submit')
                                                                   }
                                                                   })
                                                     })
                                               })
                                             </script>

                                          </div>
                                         </form>
                                         
                                       @endforeach
                                       @else
                                       <div class="m-auto">
                                        <span class="fw-bold">Diskon belum tersedia...</span>
                                       </div>
                                       @endif
                                      </div>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                              @else
                              <form action="/tambah-produk-diskon" method="POST" id="hapus_produk_diskon{{ $produk->id }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="hapus_diskon" value="hapus-diskon-here" class="d-none" readonly required>
                                <input type="hidden" name="produk_slug_hapus" value="{{ $produk->slug_id }}" class="d-none" readonly required>

                                <button type="button" class="btn btn-danger rounded-circle position-absolute me-2 end-0"  style="z-index: 999;" id="button_hapus_disk{{ $produk->id }}"><i class="fa-sharp fa-solid fa-tag fa-lg"></i></button>


                                <script>
                                  $(document).ready(function(){
                                    $('#button_hapus_disk{{ $produk->id }}').click(function(){
                                          Swal.fire({
                                                      title: 'Yakin Hapus Dari Diskon?',
                                                      text: "Menghapus produk dari diskon secara tiba-tiba mungkin akan mempengaruhi loyalitas pelanggan! ",
                                                      icon: 'warning',
                                                      showCancelButton: true,
                                                      confirmButtonColor: '#3085d6',
                                                      cancelButtonColor: '#d33',
                                                      confirmButtonText: 'Hapus!'
                                                      }).then((result) => {
                                                      if (result.isConfirmed) {
                                                        $('#hapus_produk_diskon{{ $produk->id }}').trigger('submit')
                                                      }
                                                      })
                                        })
                                  })
                                </script>
                              </form>
                               @endif
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
                                    <form action="{{ route('arsip_product' ,[ $produk->slug_id , 'arsip']) }}" method="POST">
                                      @method('put')
                                      @csrf
                                      <button class="button"><span><i class="fa-sharp fa-solid fa-lock"></i></span></button>
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
                       @php
                           $idx++;
                       @endphp             
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
