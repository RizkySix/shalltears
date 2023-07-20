@extends('components.conten_main')

@section('css')
<link rel="stylesheet" href="/css/loginregis.css">
<link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('container')
    <div class="container mb-4" style="margin-top:100px;">
        <div class="row">
            <div class="col-sm-12">
                <a href="/user-orders-view" class="text-decoration-none btn btn-warning btn3d" style="color:aliceblue; margin-right:10px;" target="___blank">Pesanan Anda</a>
                <a href="/user-keranjang" class="text-decoration-none btn btn-primary btn3d" style="color:aliceblue; margin-right:10px; width:80px;"><i class="fa-sharp fa-solid fa-cart-shopping"></i></a>
               
                <hr style="color:aliceblue">

                <div class="col-sm-12 d-flex justify-content-center flex-wrap">
                    @if (auth()->user()->role == 1306)
                    <div class="card col-sm-5 me-4">
                        <div class="card-body">
                            <span class="fw-bold h5">Hai, {{ auth()->user()->nama }}</span>
                            <p class="mt-4">
                                Terimakasih sudah bergabung dengan menjadi salah satu partisipan designer dari Shalltears Clothing Store. Kamu dapat menyumbangkan ide-ide menarik dan anti-mainstream designmu disini, dan tentu saja kamu bisa mendapatkan fame dan keuntungan!. Kamu juga dapat ikut serta untuk memberikan vote dari design-design yang terpilih dengan <span class="fw-bold">pergi kehalaman Votings</span>, design yang mendapatkan suara terbanyak sampai batas waktu yang ditentukan akan diproduksi dan pemilik design akan mendapatkan keuntungan. Dan support kami dengan membeli produk-produk kami
                            </p>
                        </div>
                    </div>
                    <div class="card col-sm-5 me-4">
                        <div class="card-body">
                            <span class="fw-bold h5">Bagikan design mu!</span>
                            <p class="mt-4">
                               Kami secara konsisten akan selalu membuat pengumuman untuk mencari design-design yang menarik dan sesuai dengan tema yang nanti akan kami berikan. Sebagai designer kamu dapat berpartisipasi dengan menyumbangkan ide mu. Jika design mu lebih menarik dari design-design lainnya design mu berkesempatan untuk masuk ke tahap voting, tenang saja kami akan memilih beberapa design. Berikut 2 langkah untuk ikut serta menyumbang design kamu,<br>

                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">1)</span>
                                <span class="fw-bold">Pergi ke halaman Announcement</span>
                               </div>
                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">2)</span>
                                <span class="fw-bold">Kirim foto,file RaR/Zip project design mu, kemudian lengkapi deskripsi atau filosofi dari design yang kamu buat</span>
                               </div>
                               
                            </p>
                        </div>
                    </div>
                    <div class="card col-sm-5 me-4 mt-4">
                        <div class="card-body">
                            <span class="fw-bold h5">Cairkan point mu!</span>
                            <p class="mt-4">
                               Jika design mu terpilih dan mendapatkan suara terbanyak pada tahap voting, kamu akan mendapatkan point yang nantinya dapat kamu cairkan dengan uang dari setiap produk yang terjual pada website yang menggunakan design kamu. Berikut informasi dan langkah-langkah pencairan point, 
                                <br>

                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">1)</span>
                                <span class="fw-bold">Pergi ke profile, dan scroll-down sampai ke menu kontribusi designer</span>
                               </div>
                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">2)</span>
                                <span class="fw-bold">Pada table memberikan informasi point yang kamu miliki, dengan perhitungan 25% dari setiap pcs produk yang terjual dalam 2 bulan pertama pada website</span>
                               </div>
                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">3)</span>
                                <span class="fw-bold">Jika produk yang terjual pada wesbite kurang dari 12 pcs, kamu tetap mendapat point 15% dari total produk yang dijual.</span>
                               </div>
                               <div class="d-flex mb-2">
                                <span class="fw-bold me-3">4)</span>
                                <span class="fw-bold">Untuk mencairkan point kamu hanya perlu klik icon pada table dan melengkapi form, kemudian dalam 1x24 jam kami akan mengirim uang mu.</span>
                               </div>
                               
                            </p>
                        </div>
                    </div>
                    
                    @endif

                    @if (auth()->user()->role == 1201)
                    <div class="card col-sm-5 me-4">
                        <div class="card-body">
                            <span class="fw-bold h5">Hai, {{ auth()->user()->nama }}</span>
                            <p class="mt-4">
                                Terimakasih sudah bergabung dengan Shalltears Clothing Store. Kamu dapat ikut serta untuk memberikan vote dari design-design yang terpilih dengan <span class="fw-bold">pergi kehalaman Votings</span>, design yang mendapatkan suara terbanyak sampai batas waktu yang ditentukan akan diproduksi dan pemilik design akan mendapatkan keuntungan. Dan support kami dengan membeli produk-produk kami
                            </p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

       <!-- Footer-->
      <div style="margin-top:250px;">
        @include('components.footer')
      </div>
@endsection