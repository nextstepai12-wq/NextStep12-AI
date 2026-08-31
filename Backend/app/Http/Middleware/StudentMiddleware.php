<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          if(!auth()->check()){
            return redirect()->route('login');
        }
        if(auth()->user()->role !== "student"){
            abort(403, 'انت غير مصرح للدخول');
        }
        return $next($request);
    }
}
