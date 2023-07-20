<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        session()->flash('regis_here' , true);
    
        $message = [
            'nama.min' => 'Nama minimal 3 karakter',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.confirmed' => 'Konfirmasi password salah',
            'exmImg.image' => 'File harus berupa gambar',
            'exmImg.max' => 'Gambar design yang dikirim harus dibawah 5mb',
        ];
       $validatedData =  $request->validate([
            'nama' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|confirmed|min:8',
            'exmImg' => 'nullable|image|file|max:5100'
        ] , $message);

        if($request->role){
           $validatedData['role'] = 1306;//role untuk designer
        }else{
            $validatedData['role'] = 1201;//role untuk customer
        }
      

        $validatedData['password'] = Hash::make($validatedData['password']);

        //upload gambar
        if($request->file('exmImg') && $request->role){
            $validatedData['exmImg'] = $request->file('exmImg')->store('exm-images');
        }else{
            $validatedData['exmImg'] = null;
        }

        $user = User::create($validatedData);

        event(new Registered($user));

        Auth::login($user);
    
        return redirect()->intended(RouteServiceProvider::HOME);
       
    }
}
