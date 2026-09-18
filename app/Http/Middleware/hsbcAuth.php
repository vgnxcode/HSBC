<?php

namespace vgn\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class hsbcAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('hsbc_logged_in')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}