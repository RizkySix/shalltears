<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profile kamu.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 needs-validation" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <label for="gmb" class="position-relative" style="cursor: pointer;">
              @if ($user->foto_profile)
               <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="gambar rusak" id="img-preview" class="img-fluid rounded-circle" style="width:100px; height:100px; object-fit:cover;">
               @else
               <img src="/imgs/kentang.jpg" alt="gambar rusak" id="img-preview" class="img-fluid rounded-circle" style="width:100px; height:100px; object-fit:cover;">
              @endif
              <input type="file" name="foto_profile" class="form-control d-none" id="gmb" onchange="previewImage()">
              <span class="position-absolute top-100 start-50 translate-middle badge rounded" id="notif" style="background-color:rgba(47, 53, 53, 0.8); font-size:20px; margin-top:-5px;">
                  <i class="fa-sharp fa-solid fa-camera" style="color:ghostwhite"></i>
               </span>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('foto_profile')" />
            <br> <br>
              @can('designer')
              <span class="fw-bold" style="color:gold">

                @for($i = 0; $i < auth()->user()->star; $i++)
                <i class="fa-sharp fa-solid fa-star"></i>
                @endfor
        
               </span> 
              @endcan

          </div>

          <script>
            function previewImage() {
                const image = document.querySelector('#gmb');
                const imgPreview = document.querySelector('#img-preview');

                if (image.files.length > 0 && image.files[0]) {
                // User memilih file gambar
                const blob = URL.createObjectURL(image.files[0]);
                imgPreview.src = blob;
                } else {
                // User tidak memilih file gambar
                imgPreview.src = '/imgs/kentang.jpg'; // Mengganti gambar dengan placeholder
                }
            }
          </script>

        <div>
            <x-input-label for="nama" :value="__('Nama')" />
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->nama)" required autofocus autocomplete="nama" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="no_hp" :value="__('No.Handphone')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="format_number mt-1 block w-full" :value="old('no_hp', $user->no_hp)"  autocomplete="no_hp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>

        <div>
            <x-input-label for="nama_rekening" :value="__('Rekening')" />
                @php
                $selectedValue = old('nama_rekening', auth()->user()->nama_rekening);
            @endphp
            <select id="nama_rekening" name="nama_rekening" class="form-select mt-1 block w-full" style="height:40px;">
                <option value="BCA" {{ $selectedValue == 'BCA' ? 'selected' : '' }}>BCA</option>
                <option value="BRI" {{ $selectedValue == 'BRI' ? 'selected' : '' }}>BRI</option>
                <option value="BNI" {{ $selectedValue == 'BNI' ? 'selected' : '' }}>BNI</option>
                <option value="MANDIRI" {{ $selectedValue == 'MANDIRI' ? 'selected' : '' }}>MANDIRI</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('nama_rekening')" />
        </div>

        <div>
            <x-input-label for="no_rekening" :value="__('No Rekening')" />
            <x-text-input id="no_rekening" name="no_rekening" type="text" class=" mt-1 block w-full" :value="old('no_rekening', $user->no_rekening)" placeholder="1281234567XX"  autocomplete="no_rekening" />
            <x-input-error class="mt-2" :messages="$errors->get('no_rekening')" />
        </div>

        <script>
            $(document).ready(function(){
                $('#nama_rekening').change(function(){
                    $('#no_rekening').attr('value' , '')  
                })
            })
        </script>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        $('.format_number').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, "-")
            ;
            });
            });

            const format_number =  document.querySelector(".format_number")
            format_number.addEventListener("keypress", function (evt) {
            if (evt.which < 48 || evt.which > 57)
            {
                evt.preventDefault();
            }
            });

    </script>
</section>
