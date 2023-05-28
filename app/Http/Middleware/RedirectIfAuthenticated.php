<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // Route pengecekan ketika LOGIN apakan ketika di cek sanctum sudah ada atau belum jika sudah redirect
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard('sanctum')->check()) {
                return response()->json(['status' => false, 'message' => 'You Are Logged In'], Response::HTTP_BAD_REQUEST);
                // return redirect(RouteServiceProvider::HOME);
            }
        }
        return $next($request);
    }
}