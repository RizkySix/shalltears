<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Daftar Pengguna</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    @if ($users->count())
      @foreach ($users as $user)
      <div class="card mb-2 @if($user->role == 1306 && $user->approve ==  false) d-none @endif">
        <div class="card-body d-flex">
           <div class="profile">
            @if ($user->foto_profile)
              <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="rusak" class="img-fluid rounded-circle m-auto" style="object-fit: cover; width:50px; height:50px;">
              @else
              <img src="/imgs/kentang.jpg" alt="rusak" class="img-fluid rounded-circle m-auto" style="object-fit: cover; width:50px; height:50px;">
              @endif
           </div>
           <div class="content ms-2 d-flex flex-column flex-wrap align-items-center w-50 ">
            <div class="me-auto">
              <span class="fw-bold" style="color:gold">

               @for($i = 0; $i < $user->star; $i++)
               <i class="fa-sharp fa-solid fa-star"></i>
               @endfor

              </span>
            </div>
            <div class="me-auto">
              <span class="fw-bold">{{ $user->nama }}</span>
            </div>
           </div>
           <div class="preview ms-auto">
            <button class="button" type="button" data-bs-toggle="modal" data-bs-target="#useMod{{ $user->id }}"><span><i class="fa-sharp fa-solid fa-glasses"></i></span></button>
           </div>

        

        </div>
      </div>
      @endforeach
      <div class="d-flex justify-content-center">
        {{ $users->links() }}
      </div>
    @endif
    </div>
  </div>