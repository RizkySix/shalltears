<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->role == 1201 && auth()->user()->email_verified_at != null){
            return redirect()->intended('/user-product');
        }
        return $next($request);
    }
}
