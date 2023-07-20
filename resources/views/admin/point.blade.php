@extends('components.no_navbar')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css"> 
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
                    @if ($points->count())
                        @php
                            $user = [];
                           $produk = [];
                        @endphp
                        @foreach ($points as $firstpoint)
                           @php
                               $produk[] = array(
                                    'user_id' => $firstpoint->user_id,
                                    'nama_produk' => $firstpoint->selling_produk->nama_produk  ,
                                    'point_request' => $firstpoint->point_request,
                                    'sisa_point' => $firstpoint->selling_produk->user_point
                                     );
                           @endphp
                          
                        @endforeach

                        @foreach ($points as $point)
                            @php
                                $total_req_point = 0;
                                $sisa_point = 0;
                            @endphp
                            @if (!in_array($point->user_id , $user))
                            <div class="card w-25 me-4">
                                <div class="card-body text-center">
                                <span class="h5 fw-bold">{{ $point->user->nama }}</span><br>
                                <hr>
                                
                                <div class="d-flex flex-column flex-wrap">
                                    <span class="fw-bold mb-3">From product :</span>
                                     @foreach ($produk as $item)
                                      @if ($item['user_id'] == $point->user_id)
                                            <span class="text-muted"> - {{ $item['nama_produk'] }}</span>


                                      @php
                                          $total_req_point += $item['point_request'];

                                          $sisa_point += $item['sisa_point'];
                                      @endphp
                                        
                                        
                                      @endif

                                    

                                  @endforeach
                                  <span class="fw-bold mt-3">Rekening tujuan :</span>
                                    <span class="text-muted">{{ $point->no_rekening }} ({{ $point->nama_rekening }})</span>

                                    <span class="fw-bold mt-3">No.Handphone :</span>
                                    @if ($point->user->no_hp)
                                    <span class="text-muted">{{ $point->user->no_hp }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif

                                    <span class="fw-bold mt-3">Sisa point :</span>
                                    <span class="text-muted">{{ str_replace(',' , '.' , number_format($sisa_point)) }}</span>

                                    <span class="fw-bold mt-3">Request point :</span>
                                    <span class="text-muted">{{ str_replace(',' , '.' , number_format($total_req_point)) }}</span>
                                </div>

                                    <div class="card-footer d-flex justify-content-center">
                                        <button class="button mt-3" type="button" data-bs-toggle="modal" data-bs-target="#cair{{ $point->id }}"><span>Cairkan</span></button>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="cair{{ $point->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Pencairan Point</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/point-done/{{ $point->user_id }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body text-center">
                                                <span class="text-muted">Masukan bukti transfer pencairan point yang sesuai.</span>

                                               <div class="d-flex flex-column justify-content-center w-25 m-auto" >
                                                <img src="" id="img-preview{{ $point->id }}" class="img-preview img-fluid d-block mb-2 mt-4" style="object-fit: cover;">
                                                <label for="gmb{{ $point->id }}" class="lblGmb form-label" id="szz">
                                                  Upload file
                                                </label>
                                                <input type="file" class="gambarEx form-control d-none" name="bukti_tf" id="gmb{{ $point->id }}" onchange="previewImage{{ $point->id }}()" required>
                                               </div>

                                               
                                               <input type="hidden" name="no_rekening" value="{{ $point->no_rekening }}" class="d-none" required readonly>
                                               <input type="hidden" name="nama_rekening" value="{{ $point->nama_rekening }}" class="d-none" required readonly>

                                               <input type="hidden" name="total_point" value="{{ str_replace(',' , '.' , number_format($total_req_point)) }}" class="d-none" required readonly>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>

                                    <script>
                                         function previewImage{{ $point->id }}()
                                            {
                                            const image = document.querySelector('#gmb{{ $point->id }}');
                                            const imgPreview = document.querySelector('#img-preview{{ $point->id }}');
                            
                                            imgPreview.style.display = 'block';
                                            
                                            
                                            const blob = URL.createObjectURL(image.files[0]);
                                            imgPreview.src = blob;
                                            }
                                    </script>

                                </div>
                            </div>
                            @php
                                $user[] = $point->user_id;
                            @endphp
                            @endif
                          @endforeach

                        <div class="mt-4">
                            {{ $points->links() }}
                        </div>
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