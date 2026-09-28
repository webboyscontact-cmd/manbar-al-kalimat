<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminIsAuthenticated
{
    /**
     * يمنع أي زائر غير مسجل الدخول كمدير من الوصول إلى لوحة التحكم.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'غير مصرح لك بالوصول.'], 401);
            }

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
