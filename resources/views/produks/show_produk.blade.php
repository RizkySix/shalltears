@extends('components.conten_main')

@section('css')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/user_product.css">
<style>
  
</style>
 <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
 <script type="text/javascript"
 src="https://app.sandbox.midtrans.com/snap/snap.js"
 data-client-key="SB-Mid-client-eoxKdd_O3x1--7pt"></script>
<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endsection

@section('container')
    <div class="container" style="">
        <div class="row">
            <div class="col-sm-12 ">
             
                <div class="vh-100 d-flex justify-content-center align-items-center">
                    <div class="card text-center" style="width: 28rem;">
                        <div class="card-header h5">
                          Informasi Pesanan
                        </div>
                        <ul class="list-group list-group-flush">
                        <form action="/show-product-post" method="POST" id="submit_form">
                          @csrf
                            <li class="list-group-item"><span class="text-muted">Nama Produk :</span> {{ request('nama_produk') }}</li>
                            <li class="list-group-item"><span class="text-muted">Category :</span> {{ request('category_produk') }}</li>
                            <li class="list-group-item"><span class="text-muted">Warna :</span> {{ request('warna') }}</li>
                            <li class="list-group-item"><span class="text-muted">Harga/pcs :</span> Rp {{ str_replace(',' , '.' , number_format($harga)) }}</li>
                            <li class="list-group-item"><span class="text-muted">Size/Qty :</span> {{ $size }} ({{ request('qty') }})</li>
                            <li class="list-group-item"><span class="text-muted">Nama pemesan :</span> {{ request('pemesan') }}</li>
                            <li class="list-group-item"><span class="text-muted">Alamat tujuan :</span> {{ request('alamat') }}</li>
                            <li class="list-group-item"><span class="text-muted">No.Hp :</span> {{ request('no_hp') }}</li>
                            <div class="card-header h5">
                                Total Pembayaran
                              </div>
                             @php
                                 $harga_satuan = str_replace('.' , '' , $harga);
                                 $harga_total = $harga_satuan * request('qty');
                             @endphp

                            <li class="list-group-item"><span class="fw-bold">Rp {{ str_replace(',' , '.' , number_format($harga_total)) }}</span></li>

                            <input type="hidden" class="form-control" name="json" id="json_callback">
                            <input type="hidden" class="form-control" name="pemesan" value="{{ request('pemesan') }}" >
                            <input type="hidden" class="form-control" name="nama_produk" value="{{ request('nama_produk') }}" >
                            <input type="hidden" class="form-control" name="warna" value="{{ request('warna') }}" >
                            <input type="hidden" class="form-control" name="alamat" value="{{ request('alamat') }}" >
                            <input type="hidden" class="form-control" name="qty" value="{{ request('qty') }}" >
                            <input type="hidden" class="form-control" name="harga" value="{{ $harga }}" >
                            <input type="hidden" class="form-control" name="no_hp" value="{{ request('no_hp') }}" >
                            <input type="hidden" class="form-control" name="produk_id" value="{{ request('produk_id') }}" >
                            <input type="hidden" class="form-control" name="cutting_id" value="{{ request('cutting_id') }}" >

                          </form>
                             <li class="list-group-item d-flex justify-content-center"><button class="button" id="pay-button"><span>Bayar Pesanan</span></button></li>
                        
                             @if (session('success'))
                                 <script>
                                  alert({{ session('success') }})
                                 </script>
                             @endif

                        <script type="text/javascript">
                            // For example trigger on button clicked, or any time you need
                            var payButton = document.getElementById('pay-button');
                            payButton.addEventListener('click', function () {
                              // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                              window.snap.pay('{{ $snapToken }}', {
                                onSuccess: function(result){
                                  /* You may add your own implementation here */
                                console.log(result);
                                  send_response(result)
                                },
                                onPending: function(result){
                                  /* You may add your own implementation here */
                                   console.log(result);
                                  send_response(result)
                                },
                                onError: function(result){
                                  /* You may add your own implementation here */
                                   console.log(result);
                                  send_response(result)
                                },
                                onClose: function(){
                                  /* You may add your own implementation here */
                               
                                }
                              })
                            });


                            function send_response(result){
                              var theResult = document.getElementById('json_callback').value = JSON.stringify(result)
                              $('#submit_form').submit()
                            }
                          </script>
                            
                        </ul>
                      </div>
                </div>
           
               </div>
        </div>
    </div>
    </div>

  
@endsection