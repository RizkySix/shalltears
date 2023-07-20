<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shalltears Landing Page</title>
        <!-- Favicon-->
        <link rel="icon" href="/imgs/S2.png" type="image/png">
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Simple line icons-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/landing_page.css" rel="stylesheet" />
      
        <style>
            body{
                background: black;
            font-family: 'Itim', cursive;
        }
        </style>
      
    </head>
    
    <body id="page-top">

        <!-- Header-->
        <header class="masthead d-flex align-items-center">
            <div class="container px-4 px-lg-5 text-center" style="color: rgb(93, 162, 161);">
                <h1 class="mb-1">Shalltears</h1>
                <h3 class="mb-5"><em>Malicious Devil Pays For Your Soul But Shalltears Pays For Your Furious</em></h3>
                <a  type="button"  class="btn btn-danger btn-xl  me-4  text-decoration-none"href="{{ route('login') }}"><span class="fw-bold" style="font-size: 21px;">Log Me In</span></a>
            </div>
        </header>
        
        <!-- Services-->
        <section class="content-section bg-dark text-white text-center" id="services">
            <div class="container px-4 px-lg-5">
                <div class="content-section-heading">
                    <h3 class="text-secondary mb-0">Services</h3>
                    <h2 class="mb-5">Penawaran</h2>
                </div>
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                        <span class="service-icon rounded-circle mx-auto mb-3"><i class="fa-solid fa-book-skull"></i></span>
                        <h4><strong>Cool Design</strong></h4>
                        <p class="text-faded mb-0">Menawarkan design-design pakaian unik dan anti-mainstream dari berbagai designer!</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                        <span class="service-icon rounded-circle mx-auto mb-3"><i class="fa-solid fa-face-grin-stars"></i></span>
                        <h4><strong>Cash and Fame</strong></h4>
                        <p class="text-faded mb-0">Mendaftar sebagai designer bisa dapetin duit dan dikenal!</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                        <span class="service-icon rounded-circle mx-auto mb-3"><i class="icon-like"></i></span>
                        <h4><strong>Cool Price Great Product</strong></h4>
                        <p class="text-faded mb-0">
                            <i class="fas fa-heart"></i>
                           Harga produk yang terjangkau, dijamin keren dan ga ketinggalan jaman!
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <span class="service-icon rounded-circle mx-auto mb-3"><i class="fa-solid fa-money-check-dollar"></i></span>
                        <h4><strong>Simple Payment</strong></h4>
                        <p class="text-faded mb-0">Sistem pembayaran yang aman dan simple!</p>
                    </div>
                </div>
            </div>
        </section>
       
       
        <!-- Footer-->
        @include('components.footer')


        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" id="scroller" href="#page-top"><i class="fas fa-angle-up"></i></a>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/landing_page.js"></script>
    </body>
</html>
