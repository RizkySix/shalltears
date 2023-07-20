@extends('auth.authMain')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css">   
<link rel="stylesheet" href="/css/dashboard.css">
<style>
  .error-feedback{
            font-size: .875em;
            color: #dc3545;
        }

    ul li a{
      opacity: 50%;
    }
</style>
@endsection

@section('container')
<div class="container">
  
                   <!-- Button trigger modal -->
                   <button type="button" class="modal_bts btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#designer_role" >
                    Launch static backdrop modal
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="designer_role" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <span class="h5 fw-bold">Anda mendaftar sebagai Designer</span><br><br>
                          <span>
                            Berikut adalah keuntungan yang anda dapat dengan registrasi sebagai Designer :

                          </span><br>
                         <ul>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Berpartisipasi untuk mengirim design anda pada halaman pengumuman</a>
                          </li><br>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Design-design yang terpilih akan masuk ketahap Voting, jika menarik design anda bisa jadi salah satunya</a>
                          </li><br>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Design yang mendapat pilihan terbanyak sampai waktu yang ditentukan akan di produksi dan dipasarkan</a>
                          </li><br>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Pemilik design akan mendapat keuntungan berupa point sebesar 25% dari setiap pcs produk yang terjual pada website</a>
                          </li><br>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Jika produk yang terjual kurang dari 12 pcs dalam waktu 2 bulan pertama produk dirilis, pemilik design tetap mendapat point sebesar 15% dari total produk yang dijual pada website</a>
                          </li><br>
                          <li>
                            <a href="#" style="color:black;" class="text-decoration-none">Point dapat dicairkan menjadi uang dengan nilai yang sama</a>
                          </li>
                         </ul>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="user_accept">Mengerti</button>
                        </div>
                      </div>
                    </div>
                  </div>


  <div class="inner row">
      <section class="forms-section">
          <h1 class="section-title">Shalltears Clothing Store</h1>
          <div class="forms">
            <div class="form-wrapper @if(!session('regis_here')) is-active @endif">
              <button type="button" class="switcher switcher-login">
                Login
                <span class="underline"></span>
              </button>
              <div class="form form-login">
               <fieldset>
                  <div class="text-center mb-5">
                      <img src="/imgs/shalltears.png"
                        style="width: 185px;" alt="logo">
                    
                    </div>

                    <form action="/login" method="POST" class="needs-validation" novalidate>
                      @csrf
                      <p>Silahkan login ke akun anda</p>
          
                      <div class="form-outline mb-4" id="flotid">
                        <label class="form-label" for="form2Example11">Email</label>
                        <input type="email" name="email" id="form2Example11" class="form-control" placeholder="Email terdaftar" autofocus required />
                        @error ('email')
                            <div class="error-feedback">
                              Akun anda tidak cocok dengan data kami :(
                            </div>
                        @enderror
                      </div>
          
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example22">Password</label>
                        <input type="password" name="password" id="form2Example22" class="form-control" required autofocus />
                      </div>
          
                      <div class="text-center pt-1 mb-5 pb-1 d-flex justify-content-center flex-column">
                        <button class="button mb-3 w-25 m-auto" type="submit"><span>Log in</span></button>
                        <a class="text-muted" href="{{ route('password.request') }}">Lupa password?</a>
                      </div>
                     
                    </form>
               </fieldset>
            </div>
            </div>
            <div class="form-wrapper @if(session('regis_here')) is-active @endif">
              <button type="button" class="switcher switcher-signup">
                Sign Up
                <span class="underline"></span>
              </button>
              <div class="form form-signup">
             
                  <fieldset>
                      <h4 class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</h4>

                      <form class="mx-1 mx-md-4 needs-validation" action="/register" method="POST" enctype="multipart/form-data" novalidate id="regis_forms">
                      @csrf
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-user fa-lg me-3 fa-fw mt-4"></i>
                          <div class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example1c">Nama Anda</label>
                            <input type="text" name="nama" id="form3Example1c" class="input-regis form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required />
                            @error('nama')
                              <div class="error-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-envelope fa-lg me-3 fa-fw mt-4"></i>
                          <div class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example3c">Email</label>
                            <input type="email" name="email" id="form3Example3c" class="input-regis form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                            @error('email')
                            <div class="error-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-lock fa-lg me-3 fa-fw mt-4"></i>
                          <div class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4c">Password</label>
                            <input type="password" name="password" id="form3Example4c" class="input-regis form-control @error('password') is-invalid @enderror" required />
                            @error('password')
                            <div class="error-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-key fa-lg me-3 fa-fw mt-4"></i>
                          <div class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4cd">Konfirmasi Password</label>
                            <input type="password"  name="password_confirmation" id="form3Example4cd" class="input-regis form-control @error('password_confirmation') is-invalid @enderror" required />
                          </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-sharp fa-solid fa-user-tie fa-lg me-3 fa-fw" id="logocheck"></i>
                          <div class="form-outline flex-fill mb-0 d-flex">
                            <label for="checkbox1" class="switch" id="les" data-toggle="tooltip" data-placement="top" title="Check!, jika anda ingin mendaftar sebagai role designer">
                              <input type="checkbox" id="checkbox1" name="role" value="check" class="input-regis"> 
                              <div class="slider round"></div>
                            </label>
                           
                          </div>
                        </div>
                        <div id="exmImg" style="display: none">
                          <label for="expImg" class="form-label">Contoh Design</label>
                          <span class="text-muted" style="font-style: italic; font-size:13px;">(Kirim design pakaian terbaik anda!)</span><br>
                          <img src="/imgs/design.jpeg" width="200" height="200"  class="img-thumbnail mb-3"><br>

                          <img src="" class="img-preview img-fluid d-block mb-2">
                          <label for="gmb" class="lblGmb form-label" id="szz">
                            Upload file
                          </label>
                          <input type="file" class="gambarEx input-regis form-control d-none" name="exmImg" id="gmb" onchange="previewImage()">
                          @error('exmImg')
                            <div class="error-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
      
                        


                        <script>                           
                          $(document).ready(function(){                   
                              $("#checkbox1").change(function(e){
                                $("#exmImg").toggle("fast");            
                                  if(e.target.checked) {                
                                    $("#gmb").attr("required", true);
                                  } else{                                                                   
                                    $("#gmb").removeAttr("required");
                                  }
                              });

                              $('#les').tooltip();
                        });       

                        function previewImage() {
                            const image1 = document.querySelector('#gmb');
                            const imgPreview1 = document.querySelector('.img-preview');
                          
                            if (image1.files.length > 0 && image1.files[0]) {
                              // User memilih file gambar
                              const blob1 = URL.createObjectURL(image1.files[0]);
                              imgPreview1.src = blob1;
                            } else {
                              // User tidak memilih file gambar
                              imgPreview1.src = ''; // Mengganti gambar dengan placeholder
                            }
                          }


                     
                       </script>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                          <button type="submit" class="button mt-3" id="regis_but"><span>Register</span></button>
                        </div>
      
                      </form>
                   </fieldset>


                   
                   <script>
                     $(document).ready(function(){                   
                              $("#checkbox1").change(function(e){        
                                  if(e.target.checked) {                
                                    $('#regis_forms').submit(function(event){
                                      event.preventDefault();
                                      var isValid = true;
                                      $('.input-regis').each(function() {
                                        if ($.trim($(this).val()) == '') {
                                          isValid = false;
                                          $(this).addClass('error');
                                        }
                                        else {
                                          $(this).removeClass('error');
                                        }
                                      });

                                      if (!isValid) {
                                        //no action needed
                                      }
                                      else {
                                        $('.modal_bts').trigger('click')
                                        $('#user_accept').click(function(){
                                          $('#regis_forms').unbind('submit').submit()
                                        })
                                      }
                                  
                                    })
                                  } else{                                                                   
                                    $('#regis_forms').unbind('submit')
                                  }
                              });

                            
                        });
                               
                   </script>

                
              </div>
            </div>
          </div>
        </section>
        <!-- partial -->
        
          <script  src="/js/loginregis.js"></script>
      

        
  </div>
</div>
@endsection