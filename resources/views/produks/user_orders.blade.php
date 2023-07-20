@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">

<style>
      .vertical-line {
        display: inline-block;
        width: 1px;
        height: auto;
        background-color: black;
        margin: 0 10px;
        padding: 10px 0;
        }
        .opt1{
            color:blue;
        }

        .opt2{
            color:black;
        }
</style>

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

                <div class="col-sm-8  d-flex justify-content-center m-auto">
                    <div class="card col-sm-5 ">
                        <div class="card-body d-flex justify-content-around">
                        <div class="sepatu active d-flex flex-column text-center" style="cursor: pointer;">
                            <span><i class="opt1 fa-solid fa-anchor fa-lg"></i></span>
                            <a type="button" class="opt1 text-decoration-none">Diproses</a>
                        </div>
                        <div class="vertical-line"></div>
                        <div class="clean d-flex flex-column text-center" style="cursor: pointer;">
                            <span><i class="opt2 fa-sharp fa-solid fa-cube fa-lg"></i></span>
                            <a type="button" class="opt2  text-decoration-none">Selesai</a>
                        </div>
                        </div>
                      </div>
                </div>

                <hr style="color:ghostwhite; margin-bottom:50px;">

                <div class=" d-flex justify-content-center align-items-center flex-wrap mb-4">
    
                    <div class="data-on-null">
                        @if ($proses_ord == 0)
                        <div class="p_or">
                            <div class=" d-flex justify-content-center align-items-center flex-column" style="margin-top:150px; ">
                                <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                                <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                            </div>
                        </div>
                        @endif

                        @if ($selesai_ord == 0)
                        <div class="s_or" style="display:none;">
                            <div class=" d-flex justify-content-center align-items-center flex-column" style="margin-top:150px;">
                                <span class="h4  text-muted" style="font-size: 100px;">☹</span>
                                <span class="h4  text-muted">Belum ada data yang tersedia...</span>
                            </div>
                        </div>
                        @endif
                        
                    </div>

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
                             <div @if($order->status == 'Selesai') style="display:none;"  @endif class="@if($order->status == 'Selesai') selesai_ord @else proses_ord  @endif card w-25 me-4 mb-4 animate__animated animate__fadeIn animate__slow">
                            <div class="card-body text-center">
                                @if ($order->status == 'Dipesan')
                                     <span style="font-size:40px; color:red"><i class="fa-sharp fa-solid fa-hourglass-start"></i></span><br>
                                @elseif ($order->status == 'Dikirim')
                                    <span style="font-size:40px; color:gold"><i class="fa-sharp fa-solid fa-ship"></i></span><br>
                                @elseif ($order->status == 'Selesai')
                                    <span style="font-size:40px; color:green"><i class="fa-sharp fa-solid fa-flag-checkered"></i></span><br>
                                @endif
                            <span class="h5 fw-bold">{{ $order->status }}</span> <br>
                            
                            @if ($order->status == 'Dipesan')
                            <span class="fw-bold mt-2">(VA NUM: {{ $order->payment_code }} {{ strtoupper($order->via_payment) }})</span>
                            @endif

                            @if ($order->status != 'Dipesan')
                            <span>Kode JNE ({{ $order->jne_resi }})</span>
                            @endif
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
                                  <div class="theDetails" style="display:none;" id="theList{{ $order->id }}">
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
                            
                            @if ($order->status == 'Dikirim')
                            <div class="card-footer d-flex justify-content-center">
                                 <form action="/kelola-produk/{{ $order->order_id }}" method="POST" id="diterimaForm{{ $order->id }}">
                                     @csrf
                                     @method('put')
                                     <input type="hidden" name="user_done" class="d-none" value="{{ hash('sha256' , 'pesanan-sudah-ditangan-user') }}" readonly required>
                                     <button class="button" type="button" id="buttonDiterima{{ $order->id }}"><span>Pesanan diterima</span></button>
                                 </form>
                            </div>
                            @endif
                            
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

                                $('#buttonDiterima{{ $order->id }}').click(function(){
                                    Swal.fire({
                                                        title: 'Produk Diterima?',
                                                        text: "Pastikan produk sudah kamu terima!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Konfirmasi!'
                                                        }).then((result) => {
                                                        if (result.isConfirmed) {
                                                           $('#diterimaForm{{ $order->id }}').trigger('submit')
                                                        }
                                                        })
                                })
                            })
                          </script>

                        @endforeach
                      
                       
                    @endif
                    
                    <script>
                        $(document).ready(function(){
                            $('.opt1').click(function(){
                                $('.opt1').css('color' , 'blue');
                                $('.opt2').css('color' , 'black');
                                $('.proses_ord').show()
                                $('.selesai_ord').hide()
                                $('.p_or').show()
                                $('.s_or').hide()
                            })
    
                            $('.opt2').click(function(){
                                $('.opt1').css('color' , 'black');
                                 $('.opt2').css('color' , 'blue');
                                $('.proses_ord').hide()
                                $('.selesai_ord').show()
                                $('.s_or').show()
                                $('.p_or').hide()
                            })
                        })
                    </script>

               </div>
        </div>
    </div>
    </div>

  
@endsection