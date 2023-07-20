@if ($users->count())
@foreach ($users as $user)
<!-- Modal -->
<div class="modal fade" id="useMod{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
  <div class="modal-header">
    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">{{ $user->nama }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <div class="d-flex justify-content-center flex-column flex-wrap">
     @if ($user->foto_profile)
     <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="rusak" class="img-fluid rounded-circle m-auto" style="object-fit: cover; width:100px; height:100px;">
     @else
     <img src="/imgs/kentang.jpg" alt="rusak" class="img-fluid rounded-circle m-auto" style="object-fit: cover; width:100px; height:100px;">
     @endif
      <div class="text-center">
        <span class="fw-bold" style="color:gold">

          @for($i = 0; $i < $user->star; $i++)
          <i class="fa-sharp fa-solid fa-star"></i>
          @endfor
  
         </span> <br>
         <span class="text-muted">
          @if ($user->role == 1306)
              (Designer) <br>
              {{ $user->no_hp }}
          @elseif($user->role == 1201)
              (Customer)
          @endif
         </span>
      </div>
    </div>
    <hr>
    <div class="contribute d-flex flex-column flex-wrap">
      <span class="fw-bold text-center mb-3">Kontribusi Design:</span>
      <p class="text-muted d-flex justify-content-center">
        @if ($user->role == 1306)
          @if ($produks->count())
            @foreach ($produks as $produk)
              @if ($produk->user_id == $user->id)
                  <span class="me-3 mb-2">{{ $produk->nama_produk }}</span>
              @endif
            @endforeach
          @else 
          <span>-</span>
          @endif
        @elseif($user->role == 1201)
          <span>Customer tidak dapat berkontribusi untuk design</span>
        @endif
      </p>
    </div>
  </div>
</div>
</div>
</div>
@endforeach
@endif