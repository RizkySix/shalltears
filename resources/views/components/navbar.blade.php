<style>
    .nav-text{
        color: aliceblue;
    }

    .nav-text:hover{
        color: grey;
    }

   .active a{
    color: rgb(111, 109, 177);
   }
   .active a:hover{
    color: rgb(111, 109, 177);
   }
</style>
<nav class="navbar navbar-dark navbar-expand-lg bd-navbar d-flex bg-dark fixed-top" >
    <div class="container">
      @if (auth()->user()->role == 666)
      <a class="navbar-brand nav-text text-decoration-none h1 {{ Request::is('dashboard*') ? 'active' : '' }}" href="/dashboard">Shalltears</a>
      @endif
      @if (auth()->user()->role == 1201 || auth()->user()->role == 1306)
      <span class="navbar-brand nav-text text-decoration-none h1" style="cursor: pointer;">Shalltears</span>
      @endif
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item {{ Request::is('announcements*') ? 'active' : '' }}">
            <a class="nav-link nav-text" aria-current="page" href="/announcements">Announcements</a>
          </li>
          <li class="nav-item {{ Request::is('votings*') ? 'active' : '' }}">
            <a class="nav-link nav-text" href="/votings">Votings</a>
          </li>
          <li class="nav-item {{ Request::is('user-product*') ? 'active' : '' }}">
            <a class="nav-link nav-text" href="/user-product">Selling Produk</a>
          </li>
          @can('cust_design')
          <li class="nav-item dropdown {{ Request::is('user-keranjang*') ? 'active' : '' }}">
            <a class="nav-link nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Orders
            </a>

            
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/user-orders-view" target="___blank">Pesanan anda</a></li>
              <li><a class="dropdown-item" href="/user-keranjang">Keranjang</a></li>
             
            </ul>
          </li>
          @endcan
          
          <li class="nav-item dropdown">
            <a class="nav-link nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              @if (auth()->user()->foto_profile)
                <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="rusak" class="img-fluid rounded-circle" style="object-fit: cover; width:30px; height:30px;">
              @else
               <img src="/imgs/kentang.jpg" alt="rusak" class="img-fluid rounded-circle" style="object-fit: cover; width:30px; height:30px;">
              @endif
            </a>

            <a class="button d-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" id="show_pengguna">Pengguna Hide</a>
            
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/profile">Profile</a></li>
              <li><a class="dropdown-item" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Pengguna</a></li>
              <li><hr class="dropdown-divider"></li>
              @can('designer')
              <li><a class="info_role dropdown-item" href="#" type="button">Role Designer</a></li>
              @endcan
              <form action="/logout" method="POST">
                @csrf
               <button class="dropdown-item">Logout</button>
              </form>
            </ul>
          </li>
        </ul>


       @can('designer')
       <div id="notifys" class="notifys position-absolute top-100 end-50 animate__animated animate__fadeIn" style="width: 500px; padding:10px; position: relative; z-index: 999; display:none;">
        <div class="d-flex flex-column justify-content-center bg-light rounded" style="border: 2px solid red;">
       <div class="d-flex">
        <span class="h5 fw-bold w-75 text-center">Designer</span>
        <button type="button" class="close-info btn-close ms-auto" aria-label="Close"></button>
       </div>
          <ul>
            <li>
              <a href="#" style="color:black;" class="text-decoration-none text-muted">
                Berpartisipasi dalam mengirim design dan vote
              </a>
            </li><br>
            <li>
              <a href="#" style="color:black;" class="text-decoration-none text-muted">
               Jika design mu mendapat vote terbanyak, maka akan diproduksi
              </a>
            </li><br>
            <li>
              <a href="#" style="color:black;" class="text-decoration-none text-muted">
               Kamu akan mendapat 25% point dari setiap pcs yang terjual pada website dalam 2 bulan pertama saat produk dirilis
              </a>
            </li><br>
            <li>
              <a href="#" style="color:black;" class="text-decoration-none text-muted">
              Kamu akan mendapat 15% point dari total pcs yang dijual pada website, jika unit yang terjual kurang dari 12 pcs dalam 2 bulan pertama
              </a>
            </li><br>
            <li>
              <a href="#" style="color:black;" class="text-decoration-none text-muted">
                Point bisa kamu cairkan menjadi uang melalui profile
              </a>
            </li>
          </ul>
        </div>
      </div> 
       @endcan
                             
          @if ($route_name != 'user_dashboard' && $route_name != 'dashboard' && $route_name != 'user.keranjang')
          <form action="{{ route($route_name) }}" method="GET" class="search_div needs-validation" novalidate>
            <input type="text" class="search_input" id="search_input" name="search" value="{{ request('search') }}" placeholder="Ketik untuk mencari..." required autocomplete="off">
            <button class="search_button" type="submit" id="search_btn" >
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>  
        </form>
          @endif

        

      </div>
    </div>
  </nav>

  
  <script>
    $(document).ready(function(){
      if({{ request('data-user') }})
      {
        $('#show_pengguna').trigger('click')
      }
    })
  </script>


<script>
  $(document).ready(function(){
    $('.info_role').click(function(){
      $('.notifys').show()
    })
    $('.close-info').click(function(){
      $('.notifys').hide()
    })
  })
</script>