<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or token invalid'
            ], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: role not allowed',
                'role' => $user->role
            ], 403);
        }

        return $next($request);
    } catch (JWTException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Token is invalid or expired',
            'error' => $e->getMessage(), // tambahkan agar ketahuan
        ], 401);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Internal Server Error',
            'error' => $e->getMessage(), // ini penting untuk debug
        ], 500);
    }
}

}
