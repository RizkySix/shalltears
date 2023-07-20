@extends('auth.authMain')

@section('css')
<link rel="stylesheet" href="/css/forgotPass.css">   
<link rel="stylesheet" href="/css/dashboard.css">   

<style>
   .error-feedback{
            font-size: .875em;
            color: #dc3545;
        }

</style>
@endsection

@section('container')
<div class="konten">
    <div class="forgot-pass card text-center" >
      
        <div class="card-body px-5">
            <p class="card-text py-2">
              Silahkan masukan alamat email kamu dan kami akan mengirimkan link Reset Password untuk anda melalui email.
            </p>
           <form action="{{ route('password.email') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="form-outline">
                <label class="form-label" for="typeEmail" style="font-weight: bold; font-size: 18px">Masukkan email</label>
                @if (session('status'))
                  <p>
                    {{ session('status') }}
                  </p>
                @endif
                <input type="email" id="typeEmail" class="form-control my-3" name="email" autofocus required value="{{ old('email') }}" />
                @error('email')
                   <p class="mb-3 error-feedback"> {{ $message }}</p>
                @enderror
            </div>
            <div class="d-flex justify-content-center">
              <button class="button" type="submit"><span>Reset password</span></button>
            </div>
        </div>
           </form>
    </div>
    
</div>
@endsection
