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
                                <span style="font-size:40px; color:red"><i class="fa-sharp fa-solid fa-hourglass-start"></i></span><br>
                            <span class="h5 fw-bold">{{ $order->status }}</span><br>
                          
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
                            
                            <div class="card-footer d-flex justify-content-center">
                              @if ($order->transaction_status == 'settlement' || $order->transaction_status == 'capture')
                                  <button class="button" type="button" data-bs-toggle="modal" data-bs-target="#kirim{{ $order->id }}"><span>Kirim</span></button>
                              @else
                                 <button class="button" type="button"><span>Menunggu Pembayaran</span></button>
                              @endif
                            </div>
                        
                            <!-- Modal -->
                            <div class="modal fade" id="kirim{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Kirim produk</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/kelola-produk/{{ $order->order_id }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @method('put')
                                        <div class="modal-body text-start">
                                            <label for="jne_resi" class="form-label">Kode Resi JNE</label>
                                            <input type="text" name="jne_resi" class="form-control" placeholder="10309512512" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Dikirim</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
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