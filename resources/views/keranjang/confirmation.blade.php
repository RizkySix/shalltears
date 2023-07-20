@extends('components.conten_main')

@section('css')
    <link rel="stylesheet" href="/css/selling_view.css">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-eoxKdd_O3x1--7pt"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endsection

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 vh-100 d-flex justify-content-center align-items-center">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-header h5 fw-bold">
                      Konfirmasi Pesanan
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <form action="/use-keranjang-checkout" method="POST" id="submit_form">
                            @csrf
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($keranjangs as $keranjang)
                           @foreach (session('items') as $item)
                                @foreach ($keranjang->selling_produks as $produk)
                                    @if ($keranjang->id == $item)
                                    <div>
                                        - <span>{{ $produk->nama_produk }}</span> <br>
                                        <span class="text-muted">({{ $keranjang->cutting->cutting_name }}/{{ $keranjang->qty }})</span><br>
                                        @php
                                            $real_harga = $produk->harga_produk;
                                        @endphp
                                        @if ($produk->diskon_id && $produk->diskon->status_aktif == true)
                                            @php
                                                $persenDiskon = $produk->diskon->persen_diskon/100;
                                                $real_harga = $produk->harga_produk - ($produk->harga_produk * $persenDiskon);
                                            @endphp 
                                        @endif
                                        <span class="text-muted">Rp {{ str_replace(',' , '.' , number_format($real_harga)) }}/pcs</span>
                                        <hr>
                                    </div>
                                    @php
                                        $total += $real_harga * $keranjang->qty;
                                    @endphp
                                
                                    @endif
                            @endforeach 
                           @endforeach
                        @endforeach
                      </li>
                      <div class="card-header h5 fw-bold">
                            Total Harga
                      </div>
                      <li class="list-group-item">
                        <span>Rp {{ str_replace(',' , '.' , number_format($total)) }}</span>
                      </li>
                      <div class="card-footer">
                            <input type="hidden" name="pemesan" class="form-control d-none" value="{{ request('pemesan') }}" readonly required>
                            <input type="hidden" name="alamat" class="form-control d-none" value="{{ request('alamat') }}" readonly required>
                            <input type="hidden" name="no_hp" class="form-control d-none" value="{{ request('no_hp') }}" readonly required>
                          
                            <input type="hidden" class="form-control" name="json" id="json_callback">
                            <button type="button" class="button mt-4" id="pay-button"><span>Check Out</span></button>
                        </form>
                      </div>
                    </ul>
                  </div>

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

            </div>
        </div>
    </div>
@endsection
