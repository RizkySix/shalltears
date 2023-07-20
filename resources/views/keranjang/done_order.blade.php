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
                       @foreach ($orders as $order)
                            @if ($order->transaction_status == 'settlement' || $order->transaction_status == 'capture')
                            <span style="font-size:40px; color:gold"><i class="fa-sharp fa-solid fa-circle-check fa-lg"></i></span><br>
                            <span class="h5 fw-bold">Payment Success</span>
                        @elseif($order->transaction_status == 'pending')
                            <span style="font-size:40px; color:gold"><i class="fa-sharp fa-solid fa-clock fa-lg"></i></span><br>
                            <span class="h5 fw-bold">Waiting For Payment</span><br>
                            <span class="fw-bold mt-2">(VA NUM: {{ $order->payment_code }} {{ strtoupper($order->via_payment) }})</span>
                        @endif
                        @break
                       @endforeach
                        <hr>
                        <span class="h6 fw-bold">Transaction Info :</span>
                            <p class="text-muted d-flex flex-column mt-3">
                                <span>Nama Produk :  </span>
                                @foreach ($orders as $order)
                               - {{ $order->nama_produk }} <br>
                                 @endforeach
                            </p>
                            @foreach ($orders as $order)
                            <p class="text-muted d-flex flex-column mt-3">
                                    <span>Order ID : {{ $order->order_id }}</span>
                                    <span class="text-capitalize">Pembayaran : {{ $order->transaction_status }}</span>
                                    <span class="text-capitalize">Tipe pembayaran : {{ $order->payment_type }}</span>
                                    <span class="text-capitalize">Total bayar : Rp {{ str_replace(',' , '.' , number_format($order->gross_amount)) }}</span>
                                </p>
                                @break
                            @endforeach

                            

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