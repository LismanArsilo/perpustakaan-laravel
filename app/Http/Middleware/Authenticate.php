<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // Redirect jika tidak memiliki token
    protected function redirectTo($request)
    {
        // Lokasi redirect jika token tidak valid/salah
        dd(!$request->expectsJson());
        if (!$request->expectsJson()) {
            return response()->json(['status' => false, 'error' =>  'Your Content Type Not Valid'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
