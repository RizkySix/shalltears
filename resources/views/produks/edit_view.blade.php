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
        <div class="d-flex justify-content-center flex-column" style="padding:100px;">
            <form action="{{ route('selling_produks.update' , $produk->slug_id) }}" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
            <h4 class="text-center">Update produk {{ $produk->nama_produk }}.</h4>
            <hr>
            <div class="col-sm-12 d-flex justify-content-center">
                <div class="col-sm-4">
                 
                    <label for="nama_produk" class="text-muted form-label">Nama produk.</label>
                     <input type="text" class="form-control border-none @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk' , $produk->nama_produk) }}" required>
                     @error('nama_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                     @enderror
                </div>
            </div>

            <div class="col-sm-12 d-flex justify-content-center mt-4">
                <div class="col-sm-4">
                    <label for="category_id" class="text-muted form-label">Category produk.</label>
                    <select name="category_id" id="category_id" class="form-select " required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if ($category->id == $produk->category_id)
                                    selected
                                @endif
                                >{{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span style="font-size: .875em; color: #dc3545;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            
            <div class="col-sm-12 d-flex justify-content-center mt-4">
                <div class="col-sm-4 d-flex flex-column">
                    <label for="category_id" class="text-muted form-label">Foto produk.</label>

                    @if ($errors->has('produk_image1') || $errors->has('produk_image2') || $errors->has('produk_image3') || $errors->has('produk_image4') || $errors->has('produk_image5') || $errors->has('produk_image6') || $errors->has('produk_image7') || $errors->has('produk_image8'))
                      <span style="font-size: .875em; color: #dc3545;">Masukan format gambar dengan benar.</span>
                    @endif

                    <span style="font-size: .875em; color: #dc3545; display:none;" id="image_fillable">Foto produk harus dilengkapi.</span>
                    <br>
                    <div class="d-flex flex-row flex-wrap justify-content-between" style="margin-top:-20px;">
                            
                    {{-- image 1 --}}
                      <div id="gambar_produk" style="margin:5px 5px">
                       
                       @if ($produk->produk_image1)
                        <div class="position-relative">
                            <label for="gmb" class="lblGmb mb-3 form-label" id="label_image1">
                                <img src="{{ asset('storage/' . $produk->produk_image1) }}" id="img-preview" class="img-fluid" style="width: 80px; height:100px;">
                            </label>
                            <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                <span  class="text-decoration-none text-wrap" style="color:crimson;">1</span>
                              </button>
                           
                        </div>
                        @endif
                      <input type="file" class="gambarEx gmb form-control d-none" name="produk_image1" id="gmb" onchange="previewImage1()">
                      </div>
                

                    {{-- image 2 --}}
                    @if ($produk->produk_image2)
                       <div id="gambar_produk2" class="gmb_produk" style="margin:5px 5px;">
                    
                         <div class="position-relative">
                            <label for="gmb2" class="lblGmb mb-3 form-label" id="szz2">
                                <img src="{{ asset('storage/' . $produk->produk_image2) }}" id="img-preview2" class="img-fluid" style="width: 80px; height:100px;">
                            </label>
                            <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                <span  class="text-decoration-none text-wrap" style="color:crimson;">2</span>
                              </button>
                            <button type="button" id="x2" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                              </button>
                         </div>
                      
                      <input type="file" class="gambarEx form-control d-none" name="produk_image2" id="gmb2" onchange="previewImage2()">
                       </div>
                       @endif

                           {{-- image 3 --}}
                           @if ($produk->produk_image3)
                           <div id="gambar_produk3" class="gmb_produk" style="margin:5px 5px;">
                        
                               <div class="position-relative">
                                <label for="gmb3" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image3) }}" id="img-preview3" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">3</span>
                                  </button>
                                  <button type="button" id="x3" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                               </div>
                            
                          <input type="file" class="gambarEx form-control d-none" name="produk_image3" id="gmb3" onchange="previewImage3()">
                           </div>
                           @endif

                            {{-- image 4 --}}
                            @if ($produk->produk_image4)
                            <div id="gambar_produk4" class="gmb_produk" style="margin:5px 5px;">
                              
                              <div class="position-relative">
                                <label for="gmb4" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image4) }}" id="img-preview4" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">4</span>
                                  </button>
                                <button type="button" id="x4" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                            
                              <input type="file" class="gambarEx form-control d-none" name="produk_image4" id="gmb4" onchange="previewImage4()">
                               </div>
                               @endif

                                {{-- image 5 --}}
                                @if ($produk->produk_image5)
                            <div id="gambar_produk5" class="gmb_produk" style="margin:5px 5px;">
                               
                              <div class="position-relative">
                                <label for="gmb5" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image5) }}" id="img-preview5" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">5</span>
                                  </button>
                                <button type="button" id="x5" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image5" id="gmb5" onchange="previewImage5()">
                               </div>
                               @endif

                                {{-- image 6 --}}
                                @if ($produk->produk_image6)
                            <div id="gambar_produk6" class="gmb_produk" style="margin:5px 5px;">
                              
                              <div class="position-relative">
                                <label for="gmb6" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image6) }}" id="img-preview6" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">6</span>
                                  </button>
                                <button type="button" id="x6" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image6" id="gmb6" onchange="previewImage6()">
                               </div>
                               @endif

                                {{-- image 7 --}}
                                @if ($produk->produk_image7)
                            <div id="gambar_produk7" class="gmb_produk" style="margin:5px 5px;">
                              
                              <div class="position-relative">
                                <label for="gmb7" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image7) }}" id="img-preview7" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">7</span>
                                  </button>
                                <button type="button" id="x7" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image7" id="gmb7" onchange="previewImage7()">
                               </div>
                               @endif

                                {{-- image 8 --}}
                                @if ($produk->produk_image8)
                            <div id="gambar_produk8" class="gmb_produk" style="margin:5px 5px;">
                               
                               <div class="position-relative">
                                <label for="gmb8" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="{{ asset('storage/' . $produk->produk_image8) }}" id="img-preview8" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">8</span>
                                  </button>
                                <button type="button" id="x8" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                               </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image8" id="gmb8" onchange="previewImage8()">
                               </div>
                               @endif

                               {{-- ############################################################################# --}}

                                {{-- jika image 2 kosong --}}
                                @if (!$produk->produk_image2)
                             <div id="gambar_produk2" class="gmb_produk" style="margin:5px 5px;">
                              
                                <div class="position-relative">
                                    <label for="gmb2" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview2" class="img-fluid" style="width: 80px; height:100px;">
                                    </label>
                                    <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                        <span  class="text-decoration-none text-wrap" style="color:crimson;">2</span>
                                      </button>
                                    <button type="button" id="nullx2" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                        <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                      </button>
                                </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image2" id="gmb2" onchange="previewImage2()">
                               </div>
                               @endif

                                {{-- jika image 3 kosong --}}
                                @if (!$produk->produk_image3)
                             <div id="gambar_produk3" class="gmb_produk" style="margin:5px 5px;">
                               <div class="position-relative">
                                <label for="gmb3" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview3" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">3</span>
                                  </button>
                                <button type="button" id="nullx3" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                               </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image3" id="gmb3" onchange="previewImage3()">
                               </div>
                               @endif

                                {{-- jika image 4 kosong --}}
                                @if (!$produk->produk_image4)
                             <div id="gambar_produk4" class="gmb_produk" style="margin:5px 5px;">
                                <div class="position-relative">
                                    <label for="gmb4" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview4" class="img-fluid" style="width: 80px; height:100px;">
                                    </label>
                                    <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                        <span  class="text-decoration-none text-wrap" style="color:crimson;">4</span>
                                      </button>
                                    <button type="button" id="nullx4" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                        <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                      </button>
                                </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image4" id="gmb4" onchange="previewImage4()">
                               </div>
                               @endif

                                {{-- jika image 5 kosong --}}
                                @if (!$produk->produk_image5)
                             <div id="gambar_produk5" class="gmb_produk" style="margin:5px 5px;">
                              <div class="position-relative">
                                <label for="gmb5" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview5" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">5</span>
                                  </button>
                                <button type="button" id="nullx5" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image5" id="gmb5" onchange="previewImage5()">
                               </div>
                               @endif

                                {{-- jika image 6 kosong --}}
                                @if (!$produk->produk_image6)
                             <div id="gambar_produk6" class="gmb_produk" style="margin:5px 5px;">
                               <div class="position-relative">
                                <label for="gmb6" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview6" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">6</span>
                                  </button>
                                <button type="button" id="nullx6" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                               </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image6" id="gmb6" onchange="previewImage6()">
                               </div>
                               @endif

                                {{-- jika image 7 kosong --}}
                                @if (!$produk->produk_image7)
                             <div id="gambar_produk7" class="gmb_produk" style="margin:5px 5px;">
                              <div class="position-relative">
                                <label for="gmb7" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview7" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">7</span>
                                  </button>
                                <button type="button" id="nullx7" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                              </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image7" id="gmb7" onchange="previewImage7()">
                               </div>
                               @endif

                                {{-- jika image 8 kosong --}}
                                @if (!$produk->produk_image8)
                             <div id="gambar_produk8" class="gmb_produk" style="margin:5px 5px;">
                               <div class="position-relative">
                                <label for="gmb8" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview8" class="img-fluid" style="width: 80px; height:100px;">
                                </label>
                                <button type="button" class="position-absolute top-0 start-0 translate-middle badge bg-light">
                                    <span  class="text-decoration-none text-wrap" style="color:crimson;">8</span>
                                  </button>
                                <button type="button" id="nullx8" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
                                    <span  class="text-decoration-none text-wrap" style="color:aliceblue;">X</span>
                                  </button>
                               </div>
                              
                              <input type="file" class="gambarEx form-control d-none" name="produk_image8" id="gmb8" onchange="previewImage8()">
                               </div>
                               @endif

                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 d-flex justify-content-center mt-3">
                <div class="col-sm-4">
                    <label for="warna_produk" class="text-muted form-label">Warna produk.</label>
                     <input type="text" class="form-control border-none w-50 @error('warna_produk') is-invalid @enderror" name="warna_produk" value="{{ old('warna_produk' , $produk->warna_produk) }}" required>
                    @error('warna_produk')
                    <div class="invalid-feedback">
                        {{ $message }}    
                    </div>  
                    @enderror 
                </div>
            </div>

            <div class="col-sm-12 d-flex justify-content-center mt-3">
                <div class="col-sm-4">
                    <label for="harga_produk" class="text-muted form-label">Harga produk.</label>
                    <div class="input-group w-50">
                        <span class="input-group-text bg-warning text-muted" id="basic-addon1">Rp</span>
                        <input type="text" class="format_uang form-control border-none @error('harga_produk') is-invalid @enderror" name="harga_produk" value="{{ old('harga_produk' , str_replace(',' , '.' , number_format($produk->harga_produk)) ) }}" required>
                        @error('harga_produk')
                        <div class="invalid-feedback">
                            {{ $message }}    
                        </div>  
                        @enderror
                    </div>
                </div>
            </div>

          {{--   <div class="col-sm-12 d-flex justify-content-center mt-3">
                <div class="col-sm-4">
                    <label for="user_id" class="text-muted form-label">ID pemilik design.</label>
                        <input type="number" class="form-control w-50 border-none @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id' , $produk->user_id) }}" required>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}    
                            </div>  
                            @enderror
                </div>
            </div> --}}

            <div class="col-sm-12 d-flex justify-content-center mt-3">
                <div class="col-sm-4">
                    <label for="deskripsi_produk" class="text-muted form-label">Deskripsi produk.</label>
                     <input type="text" class="form-control border-none @error('deskripsi_produk') is-invalid @enderror" name="deskripsi_produk" value="{{ old('deskripsi_produk' , $produk->deskripsi_produk) }}" required>
                     @error('deskripsi_produk')
                     <div class="invalid-feedback">
                        {{ $message }}    
                    </div>  
                     @enderror
                </div>
            </div>
            <hr>
        
            <div class="col-sm-12 d-flex justify-content-center mt-3">
                <div class="col-sm-4">
                  <div class="d-flex justify-content-between">
                    <label for="#">#</label>
                    <label for="size" class="text-muted form-label">Size.</label>
                    <label for="stok" class="text-muted form-label">Jumlah Stok.</label>
                  </div>
    
                        <div>
                            
                               
                                <div id="all-size">
                                    @foreach ($produk->cutting_produks as $stok)
                                    {{-- Ajax value goes here --}}
   
                                    <div class="d-flex justify-content-between " >
                                       <input type="checkbox" data-target="#check{{ $stok->id }}" class="input-check form-check-input mt-4">
                                       <label for="allsize" class="form-label text-center" style="border:2px solid white; width:60px; height:60px; padding:10px; line-height:40px; box-sizing:border-box;">{{ $stok->cutting_name }}</label>
                                       <input type="text" class="theInput form-control w-25 mb-3 btn-primary btn3d" id="check{{ $stok->id }}" name="cutting[{{ $stok->id }}]" value="{{ $stok->pivot->stok_produk }}" disabled style="background-color: rgb(232, 198, 198)">
                                    </div>
                                @endforeach
                                </div>
                                <div id="all-size2">
                                @foreach ($produk_cutting as $cutting)
                                    <div class="d-flex justify-content-between " >
                                        <input type="checkbox" data-target="#check{{ $cutting->id }}" class="input-check form-check-input mt-4">
                                        <label for="allsize" class="form-label text-center" style="border:2px solid white; width:60px; height:60px; padding:10px; line-height:40px; box-sizing:border-box;">{{ $cutting->cutting_name }}</label>
                                        <input type="text" class="theInput form-control w-25 mb-3 btn-primary btn3d" id="check{{ $cutting->id }}" name="cutting[{{ $cutting->id }}]" value="" disabled style="background-color: rgb(232, 198, 198)">
                                    </div>
                                 @endforeach
                                </div>
                                
                                <script>
                                     $('.input-check').change(function() {
                                        // Ambil status checkbox saat ini
                                        var isChecked = $(this).prop('checked');
                                        
                                        // Cari input yang terkait dan aktifkan atau nonaktifkan sesuai dengan status checkbox
                                        var targetInput = $($(this).data('target'));
                                        targetInput.prop('disabled', !isChecked);
                                        
                                        // Jika checkbox di-uncheck, hapus nilai input
                                        if (!isChecked) {
                                        
                                        targetInput.css('background-color' , 'rgb(232, 198, 198)')
                                        }else{
                                            targetInput.css('background-color' , 'ghostwhite')
                                        }
                                    });

                                        //####################################################
                                    // ambil semua elemen input
                                    const inputs = document.querySelectorAll('input');

                                    // loop melalui setiap elemen input
                                    inputs.forEach(function(input) {

                                    // cek apakah elemen input memiliki kelas yang diinginkan
                                    if (input.classList.contains('theInput')) {
                                        input.addEventListener("keypress", function (evt) {
                                        if (evt.which < 48 || evt.which > 57)
                                        {
                                            evt.preventDefault();
                                        }
                                        });
                                    }
                                    });
                                </script>
                               
                           
                            <div id="nullvalue" style="display: none;" class="justify-content-center">
                                <span class="m-auto" style="border:2px solid ghostwhite; padding:5px; border-sizing:border-box;">Woops silahkan pilih category pakaian.</span>
                            </div>
                        </div>
                      <hr>
    
                </div>
            </div>

            <div class="col-sm-12 d-flex justify-content-center mt-4">
                <div class="col-sm-4">
                
                    <button class="button" id="submitForm"><span>Update</span></button>
                   
                </div>
            </div>
           
        </form>



        {{-- delete image --}}
        @if ($produk->produk_image2)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image2" method="POST" id="delform2">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image3)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image3" method="POST" id="delform3">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image4)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image4" method="POST" id="delform4">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image5)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image5" method="POST" id="delform5">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image6)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image6" method="POST" id="delform6">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image7)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image7" method="POST" id="delform7">
            @method('put')
            @csrf
        </form>
        @endif

        @if ($produk->produk_image8)   
        <form action="/delete-image-produk/{{ $produk->slug_id }}/produk_image8" method="POST" id="delform8">
            @method('put')
            @csrf
        </form>
        @endif

        </div>
    </div>
</div>


<script src="/js/create_view_produk.js"></script>
<script src="/js/format_uang.js"></script>

<script>
    $('#category_id').on('change', function() {
    const selectedOption = $(this).val();

    // membuat permintaan Ajax ke server
    $.ajax({
        type: "GET",
        url: "/update-cutting-size/" + selectedOption + "/" + {{ $produk->id }},
        dataType: "json",
        success: function(data) {
        const theSize = data[0];
        const theStok = data[1];

        // menghapus data lama dari halaman web

          if(selectedOption != 0){
            $('#nullvalue').css('display' , 'none');
          }else{
            $('#nullvalue').css('display' , 'flex');
          }
      
        // menampilkan data ke halaman web
        if(theSize == {{ $produk->category_id }}){
            $('#all-size').empty();
            $('#all-size2').css('display' , 'block');

            theStok.forEach(function(stoks) {
                const inputCheck = $('<input type="checkbox" data-target="#check' + stoks.id + '" class="input-check form-check-input mt-4">');

                const cuttingName = $('<label for="allsize" class="form-label text-center" style="border:2px solid white; width:60px; height:60px; padding:10px; line-height:40px; box-sizing:border-box;">' + stoks.cutting_name + '</label>');

                const stokProduk = $('<input type="text" class="theInput form-control w-25 mb-3 btn-primary btn3d" id="check' + stoks.id + '" name="cutting[' + stoks.id + ']" value="' + stoks.pivot.stok_produk +'"  disabled style="background-color: rgb(232, 198, 198)">');

            const theDiv = $('<div class="d-flex justify-content-between " ></div>');

            theDiv.append(inputCheck, cuttingName, stokProduk);
            $('#all-size').append(theDiv);
            
            });

        }else{
            $('#all-size').empty();
            $('#all-size2').css('display' , 'none');

            $.each(theSize, function(index, value) {
         const inputCheck = $('<input type="checkbox" data-target="#check' + value.id + '" class="input-check form-check-input mt-4">');

        const cuttingName = $('<label for="allsize" class="form-label text-center" style="border:2px solid white; width:60px; height:60px; padding:10px; line-height:40px; box-sizing:border-box;">' + value.cutting_name + '</label>');

        const stokProduk = $('<input type="text" class="theInput form-control w-25 mb-3 btn-primary btn3d" id="check' + value.id + '" name="cutting[' + value.id + ']" value=""  disabled style="background-color: rgb(232, 198, 198)">');

       const theDiv = $('<div class="d-flex justify-content-between " ></div>');

       theDiv.append(inputCheck, cuttingName, stokProduk);
       $('#all-size').append(theDiv);
        });

        }

        //##########################################
        $('.input-check').change(function() {
        // Ambil status checkbox saat ini
        var isChecked = $(this).prop('checked');
        
        // Cari input yang terkait dan aktifkan atau nonaktifkan sesuai dengan status checkbox
        var targetInput = $($(this).data('target'));
        targetInput.prop('disabled', !isChecked);
        
        // Jika checkbox di-uncheck, hapus nilai input
        if (!isChecked) {
         
          targetInput.css('background-color' , 'rgb(232, 198, 198)')
        }else{
            targetInput.css('background-color' , 'ghostwhite')
        }
     });

        //####################################################
      // ambil semua elemen input
      const inputs = document.querySelectorAll('input');

    // loop melalui setiap elemen input
    inputs.forEach(function(input) {

    // cek apakah elemen input memiliki kelas yang diinginkan
    if (input.classList.contains('theInput')) {
        input.addEventListener("keypress", function (evt) {
        if (evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
        });
    }
    });
      
        },
        error: function(xhr, status, error) {
        // menangani kesalahan jika terjadi
        console.log(error);
        }
    });
    });
  </script>

<script>
    $(document).ready(function(){
        //image2
        $('#gmb2').on('change' , function(){
            $('#nullx2').css('display' , 'block');
            $('#nullx2').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview2').attr('src' , '/imgs/plus.png');
                $('#gmb2').val('');
            })
        })
        //image3
        $('#gmb3').on('change' , function(){
            $('#nullx3').css('display' , 'block');
            $('#nullx3').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview3').attr('src' , '/imgs/plus.png');
                $('#gmb3').val('');
            })
        })
         //image4
         $('#gmb4').on('change' , function(){
            $('#nullx4').css('display' , 'block');
            $('#nullx4').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview4').attr('src' , '/imgs/plus.png');
                $('#gmb4').val('');
            })
        })
         //image5
         $('#gmb5').on('change' , function(){
            $('#nullx5').css('display' , 'block');
            $('#nullx5').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview5').attr('src' , '/imgs/plus.png');
                $('#gmb5').val('');
            })
        })
         //image6
         $('#gmb6').on('change' , function(){
            $('#nullx6').css('display' , 'block');
            $('#nullx6').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview6').attr('src' , '/imgs/plus.png');
                $('#gmb6').val('');
            })
        })
         //image7
         $('#gmb7').on('change' , function(){
            $('#nullx7').css('display' , 'block');
            $('#nullx7').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview7').attr('src' , '/imgs/plus.png');
                $('#gmb7').val('');
            })
        })
         //image8
         $('#gmb8').on('change' , function(){
            $('#nullx8').css('display' , 'block');
            $('#nullx8').click(function(){
                $(this).css('display' , 'none');
                $('#img-preview8').attr('src' , '/imgs/plus.png');
                $('#gmb8').val('');
            })
        })
        

        ///////////delete image 
        //delete produk_image2
        $('#x2').click(function(){
            $('#delform2').trigger('submit');
        })
        //delete produk_image3
        $('#x3').click(function(){
            $('#delform3').trigger('submit');
        })
        //delete produk_image4
        $('#x4').click(function(){
            $('#delform4').trigger('submit');
        })
        //delete produk_image5
        $('#x5').click(function(){
            $('#delform5').trigger('submit');
        })
        //delete produk_image6
        $('#x6').click(function(){
            $('#delform6').trigger('submit');
        })
        //delete produk_image7
        $('#x7').click(function(){
            $('#delform7').trigger('submit');
        })
        //delete produk_image8
        $('#x8').click(function(){
            $('#delform8').trigger('submit');
        })
    })
</script>

@endsection