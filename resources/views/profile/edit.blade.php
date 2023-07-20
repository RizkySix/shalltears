@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">

 <style>
    .error-feedback{
            font-size: .875em;
            color: #dc3545;
        }
 </style>
@endsection

@section('container')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session()->has('success'))
        <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
          <strong>{{ session('success') }}</strong>
          <button type="button" style="color:black;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @can('designer')
            <div>
                <div class="card">
                    <div class="card-body">
                     <span class="h6 fw-bold">
                        Kontribusi anda sebagai designer kami:
                     </span>
                     <table class="table table-dark table-striped w-100 mt-4">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama Produk</th>
                              <th scope="col">Point</th>
                              <th scope="col">Terjual/Stok</th>
                              <th scope="col">Expired</th>
                              <th scope="col" style="width: 30%">Penarikan</th>
                              <th scope="col">Aksi</th>
                            </tr>
                          </thead>
                        <tbody>
                            @if ($produks->count())
                                @foreach ($produks as $produk)
                                    @php
                                        $stok = 0;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>{{ str_replace(',' , '.' , number_format($produk->user_point)) }}</td>
                                        <td>
                                            @foreach ($produk->cutting_produks as $cutting)
                                              @php
                                                    $stok += $cutting->pivot->stok_produk;
                                                    $final_stok = $stok + $produk->terjual;
                                              @endphp
                                        
                                            @endforeach
                                            {{ $produk->terjual }} / {{ $final_stok }}
                                        </td>
                                        <td>
                                           <div>
                                            @if (\Carbon\Carbon::parse($produk->durasi_point) < $date_now)
                                        <span class="text-danger">Sudah Expired</span>
                                         @else
                                         @if (\Carbon\Carbon::parse($produk->durasi_point)->diffInDays() >= 1)
                                          <span class="text-muted">Durasi bonus anda tersisa {{ \Carbon\Carbon::parse($produk->durasi_point)->diffInDays() }} hari lagi.</span>
                                         @else
                                         <span class="text-muted">Durasi bonus anda tersisa {{ \Carbon\Carbon::parse($produk->durasi_point)->diffInHours() }} jam lagi.</span>
                                         @endif
                                        </div>
                                        @endif
                                        </td>
                                        <td>
                                            @foreach ($points as $thepoint)
                                                @if ($thepoint->selling_produk_id == $produk->id && $thepoint->status != 'paid')
                                                    <span class="text-muted">Status penarikan <span class="fw-bold text-capitalize">{{ $thepoint->status }}</span>
                                                    sebesar  <span class="fw-bold">{{ str_replace(',' , '.' , number_format($thepoint->point_request)) }}</span>
                                                    (Dikirim dalam 1x24 jam, anda akan menerima email).
                                                </span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                           <button class="button" data-bs-toggle="modal" data-bs-target="#pay{{ $produk->id }}"><span><i class="fa-solid fa-money-check-dollar"></i></span></button>

                                            
                                            <div class="modal fade" id="pay{{ $produk->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="color:black;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Penarikan point</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" ><i class="fa-solid fa-x"></i></button>
                                                        </div>
                                                        <form action="/bonus-designer-cair" method="POST">
                                                            @csrf
                                                        <div class="modal-body text-center">
                                                            <span class="text-muted">(Minimal penarikan sebesar 25.000 point)</span><br>
                                                            <span class="text-muted">
                                                                Point anda untuk produk <span class="fw-bold">{{ $produk->nama_produk }}</span> sebanyak <span class="fw-bold">
                                                                    {{ str_replace(',' , '.' , number_format($produk->user_point)) }}
                                                                </span>
                                                            </span>
                                                            <x-text-input id="point{{ $produk->id }}" name="point_request" type="number" class="format_uang mt-4 block w-full" min="25000" max="{{ $produk->user_point }}" required autofocus autocomplete="point_request" />
                                                            @error('point_request')
                                                                <div class="error-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                            <div class="d-flex mb-3">
                                                                <x-text-input  name="nama_rekening" type="text" class="format_uang mt-4 block w-full me-3" placeholder="BCA/BNI/BRI/DLL" value="{{ auth()->user()->nama_rekening }}" required readonly autocomplete="nama_rekening"  />
                                                                
                                                                  <x-text-input  name="no_rekening" type="text" class="format_uang mt-4 block w-full" placeholder="1281234567XX" value="{{ auth()->user()->no_rekening }}" required readonly autocomplete="no_rekening"  />
                                                            </div>
                                                            
                                                            <input type="hidden" name="selling_produk_id" value="{{ $produk->id }}" class="d-none" required readonly> 
                                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" class="d-none" required readonly> 
                                                            <input type="hidden" name="max_point" value="{{ $produk->user_point }}" class="d-none" required readonly> 

                                                            <span class="text-muted">Anda belum dapat mencairkan point jika produk yang terjual kurang dari 12 pcs</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                           @if ($produk->terjual < 12 && $produk->durasi_point > $date_now)
                                                           <button class="kurang button" ><span>Kirim</span></button>

                                                           <script>
                                                                $(document).ready(function(){
                                                                    $('.kurang').click(function(e){
                                                                        e.preventDefault()
                                                                    })
                                                                })
                                                           </script>
                                                           @else
                                                           <button class="button"><span>Kirim</span></button>
                                                           @endif
                                                        </div>
                                                
                                                </form>
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                        
                                    
                                @endforeach
                            @endif
                                

                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
            @endcan

           {{--  <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
@endsection
