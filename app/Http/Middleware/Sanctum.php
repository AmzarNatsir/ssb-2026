<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Sanctum
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
        $bearer = $request->bearerToken();

        if (!$bearer) {
            return response()->json(['success' => false, 'error' => 'Access denied.'], 401);
        }

        $tokenRecord = null;

        // Format Sanctum: "{id}|{rawToken}"
        if (strpos($bearer, '|') !== false) {
            [$id, $rawToken] = explode('|', $bearer, 2);
            $record = DB::table('personal_access_tokens')->where('id', $id)->first();
            if ($record && hash_equals($record->token, hash('sha256', $rawToken))) {
                $tokenRecord = $record;
            }
        }

        if ($tokenRecord && $user = \App\User::find($tokenRecord->tokenable_id)) {
            Auth::login($user);
            return $next($request);
        }

        return response()->json(['success' => false, 'error' => 'Access denied.'], 401);
    }
}
