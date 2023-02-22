<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        if(!$token) {
            return response()->json([
                'status' => [
                    'code' => 401,
                    'message' => 'Token not provided.'
                ]
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch(ExpiredException $e) {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'message' => 'Provided token is expired.'
                ]
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'status' => [
                    'code' => 400,
                    'message' => 'An error while decoding token.'
                ]
            ], 400);
        }
        return $next($request);
    }
}
