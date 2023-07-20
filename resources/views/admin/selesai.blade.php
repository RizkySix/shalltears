@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">

 
@endsection

@section('container')
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12 ">
                @if (session()->has('success'))
                <div class="alert alert-warning alert-dismissible fade show  position-fixed top-10 start-50 translate-middle animate__animated animate__fadeInDown" role="alert" style="z-index: 9999">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @endif

                <div class=" d-flex justify-content-center align-items-center flex-wrap mb-4">
                    @if ($orders->count())
                        @php
                            $orderID = [];
                            $dataOrder = [];
                        @endphp

                    @foreach ($orders as $firstOrder)
                           @php
                                $dataOrder[] = array(
                                    'order_id' => $firstOrder->order_id,
                                    'nama_produk' => $firstOrder->nama_produk,
                                    'warna' => $firstOrder->warna,
                                    'size' => $firstOrder->size,
                                    'qty' => $firstOrder->qty,
                                    'harga' => $firstOrder->harga,
                            );
                           @endphp
                    @endforeach

                        @foreach ($orders as $order)
                        @if (!in_array($order->order_id , $orderID))
                             <div class="card w-25 me-4 mb-3">
                            <div class="card-body text-center">
                                <span style="font-size:40px; color:green"><i class="fa-sharp fa-solid fa-flag-checkered"></i></span><br>
                            <span class="h5 fw-bold">{{ $order->status }}</span><br>
                            <span>Kode JNE ({{ $order->jne_resi }})</span>
                            <hr>
                            <div id="info{{ $order->id }}">
                                <span class="h6 fw-bold">Transaction Info :</span>
                                <p class="text-muted d-flex flex-column mt-2">
                                    <span>Order ID : {{ $order->order_id }}</span>
                                    <span class="text-capitalize">Pembayaran : {{ $order->transaction_status }}</span>
                                    <span class="text-capitalize">Tipe pembayaran : {{ $order->payment_type }}</span>
                                    <span class="text-capitalize">Pemesan : {{ $order->pemesan }}</span>
                                    <span class="ms-auto mt-2" id="toggle{{ $order->id }}" style="cursor: pointer;"><i class="fa-sharp fa-solid fa-list"></i></span>
                                </p>
                                <hr>
                                @php
                                    $number_order = 1;
                                 @endphp
                                  <div class="theDetails" style="display: none;" id="theList{{ $order->id }}">
                                    @foreach ($dataOrder as $theOrders)
                                    @if ($theOrders['order_id'] == $order->order_id)
                                        <span class="h6 fw-bold">Detail Produk {{ $number_order }} :</span>
                                        <p class="text-muted d-flex flex-column mt-2">
                                            <span>Nama Produk : {{ $theOrders['nama_produk'] }}</span>
                                            <span class="text-capitalize">Warna : {{ $theOrders['warna'] }}</span>
                                            <span class="text-capitalize">Size : {{ $theOrders['size'] }}</span>
                                            <span class="text-capitalize">Jumlah : {{ $theOrders['qty'] }}</span>
                                            <span class="text-capitalize">Harga/pcs : Rp {{ str_replace(',' , '.' , number_format($theOrders['harga'])) }}</span>
                                        </p>
                                        @php
                                            $number_order += 1;
                                        @endphp
                                    @endif
                                @endforeach
                                </div>

                                            <span class="h6 fw-bold">Pengiriman :</span>
                                            <p class="d-flex flex-column mt-2">
                                                <span class="text-capitalize">Alamat pengiriman : {{ $order->alamat }}</span>
                                                <span class="text-capitalize">Total bayar : Rp {{ str_replace(',' , '.' , number_format($order->gross_amount)) }}</span>
                                            </p>
                            </div>
                            
                          
                            </div>
                          </div>

                          @php
                              $orderID[] = $order->order_id;
                          @endphp
                        @endif

                          
                        <script>
                            $(document).ready(function(){
                                $('#toggle{{ $order->id }}').click(function(){
                                    $('#theList{{ $order->id }}').toggle('fast')
                                })
                            })
                          </script>

                        @endforeach
                       
                        @else
                        <div class="d-flex justify-content-center align-items-center flex-column" style="margin-top:200px;">
                            <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                            <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                        </div>
                    @endif
                    
               </div>
        </div>
    </div>
    </div>

  
@endsection