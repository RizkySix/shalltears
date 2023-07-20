@extends('auth.authMain')

@section('css')
    <link rel="stylesheet" href="/css/forgotForm.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
       <style>
           body{
               font-family: 'Itim', cursive !important;
           }
       </style>
@endsection

@section('container')
<div class="container">
    <div class="inner row">
        <section class="forms-section">
            <div class="konten card">          
                <div class="form form-signup">          
                    <fieldset>
                        <h4 class="text-center fw-bold mb-5 mx-1 mx-md-4 mt-4 card-text">Forgot Password</h4>
  
                        <form class="mx-1 mx-md-4 needs-validation" method="POST" action="{{ route('password.store') }}" novalidate>
                        @csrf

                          <!-- Password Reset Token -->
                         <input type="hidden" name="token" value="{{ $request->route('token') }}">


                          <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw mt-4"></i>
                            <div class="form-outline flex-fill mb-0">
                              <label class="form-label" for="email">Email</label>
                              <input type="email" name="email" id="email" class="form-control" value="{{ old('email' , $request->email) }}" autofocus required />
                              @error('email')
                                  {{ $message }}
                              @enderror
                            </div>
                          </div>
        
                          <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-lock fa-lg me-3 fa-fw mt-4"></i>
                            <div class="form-outline flex-fill mb-0">
                              <label class="form-label" for="password">Password</label>
                              <input type="password" name="password" id="password" class="form-control" required />
                              @error('password')
                              {{ $message }}
                          @enderror
                            </div>
                          </div>
        
                          <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-key fa-lg me-3 fa-fw mt-4"></i>
                            <div class="form-outline flex-fill mb-0">
                              <label class="form-label" for="confirm">Konfirmasi Password</label>
                              <input type="password"  name="password_confirmation" id="confirm" class="form-control" required />
                              @error('password_confirmation')
                              {{ $message }}
                          @enderror
                            </div>
                          </div>
  
                          <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" class="button mt-3"><span>Reset Password</span></button>
                          </div>
        
                        </form>
                     </fieldset>
          
                  
                </div>
              
            </div>
          </section>
      
    </div>
  </div>
@endsection