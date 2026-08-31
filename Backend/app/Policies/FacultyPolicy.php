<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UniversityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== "university") {
            abort(403, 'انت غير مصرح للدخول');
        }

        // حماية إضافية: حساب بـrole=university بدون university_id يعني إعداد
        // ناقص من الأدمن (نسي يربطه بجامعة) — نمنعه فورًا بدل ما يوصل لأي بيانات
        // ويفشل لاحقًا بصمت أو بخطأ SQL غامض عند فحص Policies.
        if (is_null(auth()->user()->university_id)) {
            abort(403, 'حسابك غير مربوط بأي جامعة بعد. تواصل مع الإدارة.');
        }

        return $next($request);
    }
}
