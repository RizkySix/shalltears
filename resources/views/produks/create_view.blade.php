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
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-center flex-column" style="padding:100px;">
              

                <form action="{{ route('selling_produks.store') }}" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                    @csrf
                <h4 class="text-center">Buat Produk Baru.</h4>
                <hr>
                <div class="col-sm-12 d-flex justify-content-center">
                    <div class="col-sm-4">
                     
                        <label for="nama_produk" class="text-muted form-label">Nama produk.</label>
                         <input type="text" class="form-control border-none @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk') }}" required>
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
                            <option value="0">Pilih Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
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
                        <div class="d-flex flex-row flex-wrap" style="margin-top:-20px;">

                        {{-- image 1 --}}
                          <div id="gambar_produk" style="margin:5px 5px">
                           
                            <label for="gmb" class="lblGmb mb-3 form-label" id="label_image1">
                                <img src="/imgs/plus.png" id="img-preview" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                            </label>
                          <input type="file" class="gambarEx gmb form-control d-none" name="produk_image1" id="gmb" onchange="previewImage1()" required>
                            <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                <a class="btn btn-dark btn-sm border-light w-25" id="add1"><span style="font-size:14px;">+</span></a>
                                <a class="btn btn-dark btn-sm border-light w-25" id="del1" style="display:none;"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                            </div>
                          </div>

                        {{-- image 2 --}}
                           <div id="gambar_produk2" class="gmb_produk" style="display: none; margin:5px 5px;">
                            <label for="gmb2" class="lblGmb mb-3 form-label" id="szz2">
                                <img src="/imgs/plus.png" id="img-preview2" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                            </label>
                          <input type="file" class="gambarEx form-control d-none" name="produk_image2" id="gmb2" onchange="previewImage2()" disabled>
                          <div class="d-flex justify-content-center" style="margin-top:-10px;">
                            <a class="btn btn-dark btn-sm border-light w-25" id="add2" style="margin-right:3px"><span style="font-size:14px;">+</span></a>
                            <a class="btn btn-dark btn-sm border-light w-25" id="del2"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                          </div>
                           </div>

                               {{-- image 3 --}}
                               <div id="gambar_produk3" class="gmb_produk" style="display: none; margin:5px 5px;">
                                <label for="gmb3" class="lblGmb mb-3 form-label" id="szz">
                                    <img src="/imgs/plus.png" id="img-preview3" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                </label>
                              <input type="file" class="gambarEx form-control d-none" name="produk_image3" id="gmb3" onchange="previewImage3()">
                              <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                <a class="btn btn-dark btn-sm border-light w-25" id="add3" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                <a class="btn btn-dark btn-sm border-light w-25" id="del3"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                              </div>
                               </div>

                                {{-- image 4 --}}
                                <div id="gambar_produk4" class="gmb_produk" style="display: none; margin:5px 5px;">
                                    <label for="gmb4" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview4" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                    </label>
                                  <input type="file" class="gambarEx form-control d-none" name="produk_image4" id="gmb4" onchange="previewImage4()">
                                  <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                    <a class="btn btn-dark btn-sm border-light w-25" id="add4" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                    <a class="btn btn-dark btn-sm border-light w-25" id="del4"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                                  </div>
                                   </div>

                                    {{-- image 5 --}}
                                <div id="gambar_produk5" class="gmb_produk" style="display: none; margin:5px 5px;">
                                    <label for="gmb5" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview5" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                    </label>
                                  <input type="file" class="gambarEx form-control d-none" name="produk_image5" id="gmb5" onchange="previewImage5()">
                                  <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                    <a class="btn btn-dark btn-sm border-light w-25" id="add5" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                    <a class="btn btn-dark btn-sm border-light w-25" id="del5"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                                  </div>
                                   </div>

                                    {{-- image 6 --}}
                                <div id="gambar_produk6" class="gmb_produk" style="display: none; margin:5px 5px;">
                                    <label for="gmb6" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview6" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                    </label>
                                  <input type="file" class="gambarEx form-control d-none" name="produk_image6" id="gmb6" onchange="previewImage6()">
                                  <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                    <a class="btn btn-dark btn-sm border-light w-25" id="add6" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                    <a class="btn btn-dark btn-sm border-light w-25" id="del6"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                                  </div>
                                   </div>

                                    {{-- image 7 --}}
                                <div id="gambar_produk7" class="gmb_produk" style="display: none; margin:5px 5px;">
                                    <label for="gmb7" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview7" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                    </label>
                                  <input type="file" class="gambarEx form-control d-none" name="produk_image7" id="gmb7" onchange="previewImage7()">
                                  <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                    <a class="btn btn-dark btn-sm border-light w-25" id="add7" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                    <a class="btn btn-dark btn-sm border-light w-25" id="del7"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                                  </div>
                                   </div>

                                    {{-- image 8 --}}
                                <div id="gambar_produk8" class="gmb_produk" style="display: none; margin:5px 5px;">
                                    <label for="gmb8" class="lblGmb mb-3 form-label" id="szz">
                                        <img src="/imgs/plus.png" id="img-preview8" class="img-fluid" style="width: 80px; height:100px; object-fit:cover;">
                                    </label>
                                  <input type="file" class="gambarEx form-control d-none" name="produk_image8" id="gmb8" onchange="previewImage8()">
                                  <div class="d-flex justify-content-center" style="margin-top:-10px;">
                                    <a class="btn btn-dark btn-sm border-light w-25" id="add8" style="margin-right: 3px;"><span style="font-size:14px;">+</span></a>
                                    <a class="btn btn-dark btn-sm border-light w-25" id="del8"><span style="font-size:14px; padding:0px 3px;">-</span></a>
                                  </div>
                                   </div>
                                </div>
                    </div>
                </div>
                
                <div class="col-sm-12 d-flex justify-content-center mt-3">
                    <div class="col-sm-4">
                        <label for="warna_produk" class="text-muted form-label">Warna produk.</label>
                         <input type="text" class="form-control border-none w-50 @error('warna_produk') is-invalid @enderror" name="warna_produk" value="{{ old('warna_produk') }}" required>
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
                            <input type="text" class="format_uang form-control border-none @error('harga_produk') is-invalid @enderror" name="harga_produk" value="{{ old('harga_produk') }}" required>
                            @error('harga_produk')
                            <div class="invalid-feedback">
                                {{ $message }}    
                            </div>  
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 d-none mt-3">
                    <div class="col-sm-4">
                        <label for="user_id" class="text-muted form-label">ID pemilik design.</label>
                            <input type="number" class="form-control w-50 border-none @error('user_id') is-invalid @enderror" name="user_id" @if(request('the-design-of-user')) value="{{ request('the-design-of-user') }}" readonly required @else value="{{ old('user_id') }}" @endif>
                                @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}    
                                </div>  
                                @enderror
                    </div>
                </div>

                <div class="col-sm-12 d-flex justify-content-center mt-3">
                    <div class="col-sm-4">
                        <label for="deskripsi_produk" class="text-muted form-label">Deskripsi produk.</label>
                        <textarea type="text" rows="6" cols="10" name="deskripsi_produk" class="form-control @error('deskripsi_produk') is-invalid @enderror " required>{{ old('deskripsi_produk') }}</textarea>
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
                                    {{-- Ajax value goes here --}}
                                </div>
                                <div id="nullvalue" style="display: flex;" class="justify-content-center">
                                    <span class="m-auto" style="border:2px solid ghostwhite; padding:5px; border-sizing:border-box;">Woops silahkan pilih category pakaian.</span>
                                </div>
                            </div>
                          <hr>
        
                    </div>
                </div>

                <div class="col-sm-12 d-flex justify-content-center mt-4">
                    <div class="col-sm-4">
                    
                        <button class="button" id="submitForm"><span>Buat</span></button>
                       
                    </div>
                </div>
               
            </form>
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
        url: "/selected-cutting-size/" + selectedOption,
        dataType: "json",
        success: function(data) {

        // menghapus data lama dari halaman web
          $('#all-size').empty();

          if(selectedOption != 0){
            $('#nullvalue').css('display' , 'none');
          }else{
            $('#nullvalue').css('display' , 'flex');
          }
      
        // menampilkan data ke halaman web
        $.each(data, function(index, value) {
       const inputCheck = $('<input type="checkbox" data-target="#check' + value.id + '" class="input-check form-check-input mt-4">');

        const cuttingName = $('<label for="allsize" class="form-label text-center" style="border:2px solid white; width:60px; height:60px; padding:10px; line-height:40px; box-sizing:border-box;">' + value.cutting_name + '</label>');

       const stokProduk = $('<input type="text" class="theInput form-control w-25 mb-3 btn-primary btn3d" id="check' + value.id + '" name="cutting[' + value.id + ']" disabled style="background-color: rgb(232, 198, 198)">');

       const theDiv = $('<div class="d-flex justify-content-between " ></div>');

       theDiv.append(inputCheck, cuttingName, stokProduk);
       $('#all-size').append(theDiv);
       
        });


        //##########################################
        $('.input-check').change(function() {
        // Ambil status checkbox saat ini
        var isChecked = $(this).prop('checked');
        
        // Cari input yang terkait dan aktifkan atau nonaktifkan sesuai dengan status checkbox
        var targetInput = $($(this).data('target'));
        targetInput.prop('disabled', !isChecked);
        
        // Jika checkbox di-uncheck, hapus nilai input
        if (!isChecked) {
          targetInput.val('');
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
        $('#submitForm').click(function(){
            const required_produk_image1 = $('#gmb').val();

            if(required_produk_image1 == ""){
                $('#image_fillable').css('display' , 'block');
            }else{
                $('#image_fillable').css('display' , 'none');
            }
        })

    </script>

@endsection