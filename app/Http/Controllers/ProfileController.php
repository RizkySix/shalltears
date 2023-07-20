<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DesignPoint;
use App\Models\SellingProduk;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $produks = SellingProduk::where('user_id' , auth()->user()->id)->with(['category' , 'user'])->latest()->get();
        $points = DesignPoint::where('user_id' , auth()->user()->id)->latest()->get();
        return view('profile.edit', [
            'title' => 'Profile',
            'user' => $request->user(),
            'produks' => $produks,
            'date_now' => Carbon::now(),
            'points' => $points
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if($request->file('foto_profile')){
            if($request->user()->foto_profile){
                Storage::delete($request->user()->foto_profile);
            }

            $validated['foto_profile'] = $request->file('foto_profile')->store('profile_images');
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }



        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
