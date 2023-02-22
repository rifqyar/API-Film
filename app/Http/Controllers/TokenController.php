<?php
namespace App\Http\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class TokenController extends Controller{
    public function getToken(){
        try {
            $payload = [
                'iss' => "lumen~jwt~api-film",
                'sub' => 'superuser',
                'iat' => time(),
                'exp' => time() + 60*60
            ];

            return response()->json([
                'status' => [
                    'code' => 200,
                    'message' => 'OK'
                ], 'token' => JWT::encode($payload, env('JWT_SECRET'), 'HS256')
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }
    }

    public function cekToken(Request $request){
        try {
            $token = $request->header('token');
            JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            return response()->json([
                'status' => [
                    'code' => 200,
                    'message' => 'OK',
                ],
            ], 200);
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
    }
}
?>
