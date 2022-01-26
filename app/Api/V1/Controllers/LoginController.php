<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $myTTL = 720; //minutes

            //JWTAuth::factory()->setTTL($myTTL);
            $token = $JWTAuth->attempt($credentials,['exp' => Carbon::now()->addDays(1)->timestamp]);

            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'user' => $JWTAuth->toUser($token)
            ]);
    }

    public function logout(Request $request, JWTAuth $JWTAuth)
    {
       $token = $request->header( 'Authorization' );

        $token =  $JWTAuth->parseToken()->invalidate();
       if($token)
       {
          return response()->json([
               'status' => 'ok',
               'message' => 'User logged out successfully!'
          ], 200);
        } 
        else 
        {
           return response()->json([
               'message' => 'Failed to logout user. Try again.'
            ], 500);
        }
   }
}
