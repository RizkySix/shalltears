@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">
<style>
  
</style>
 
@endsection

@section('container')
    <div class="container" style="">
        <div class="row">
            <div class="col-sm-12 ">
             
                <div class="vh-100 d-flex justify-content-center align-items-center">
                    <div class="card col-sm-3">
                        <div class="card-body text-center">
                        @if ($order->transaction_status == 'settlement' || $order->transaction_status == 'capture')
                            <span style="font-size:40px; color:gold"><i class="fa-sharp fa-solid fa-circle-check fa-lg"></i></span><br>
                            <span class="h5 fw-bold">Payment Success</span>
                        @elseif($order->transaction_status == 'pending')
                            <span style="font-size:40px; color:gold"><i class="fa-sharp fa-solid fa-clock fa-lg"></i></span><br>
                            <span class="h5 fw-bold">Waiting For Payment</span>
                        @endif
                        <hr>
                        <span class="h6 fw-bold">Transaction Info :</span>
                        <p class="text-muted d-flex flex-column mt-3">
                            <span>Nama Produk : {{ $order->nama_produk }}</span>
                            <span>Order ID : {{ $order->order_id }}</span>
                            <span class="text-capitalize">Pembayaran : {{ $order->transaction_status }}</span>
                            <span class="text-capitalize">Tipe pembayaran : {{ $order->payment_type }}</span>
                          {{--   <span class="text-capitalize">Pemesan : {{ $order->pemesan }}</span>
                            <span class="text-capitalize">Warna : {{ $order->warna }}</span>
                            <span class="text-capitalize">Size : {{ $order->size }}</span>
                            <span class="text-capitalize">Jumlah : {{ $order->qty }}</span>
                            <span class="text-capitalize">Harga/pcs : Rp {{ $order->harga }}</span>
                            <span class="text-capitalize">Alamat pengiriman : {{ $order->alamat }}</span> --}}
                            <span class="text-capitalize">Total bayar : Rp {{ str_replace(',' , '.' , number_format($order->gross_amount)) }}</span>
                        </p>

                        @if (auth()->user()->role == 666)
                            <a href="/dashboard" class="button text-decoration-none" type="button"><span>Ke Dashboard</span></a>
                        @else
                        <a href="/user-product" class="button text-decoration-none" type="button"><span>Confirm</span></a>
                        @endif

                        </div>
                      </div>
                    
               </div>
        </div>
    </div>
    </div>

  
@endsection