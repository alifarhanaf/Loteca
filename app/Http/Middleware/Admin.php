<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if ($request->session()->has('user')) {
        // if(Auth::user() != null){
            return $next($request);
          }
          return redirect('login')->with('error','Permission Denied!!! You do not have administrative access.');
    }
}
