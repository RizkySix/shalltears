<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LessThanLusin
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
        diskon_start();
        diskon_expired();
        less_than_lusin();
        mail_design_terpilih();
        retrying_send_mail();
        return $next($request);
    }
}
