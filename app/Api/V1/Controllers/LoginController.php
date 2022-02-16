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
use App\User;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request, JWTAuth $JWTAuth)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ], ["email.email"=>"Incorrect Email"]);
         if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages()->first();
                //$errors = $validator->errors();
                // redirect our user back to the form with the errors from the validator
                 return response()
                            ->json([
                                'status' => 'fail',
                                'msg' => $messages
                                //"errors" => $errors,
                            ]);
            }

        $credentials = $request->only(['email', 'password']);

        try {
            $myTTL = 720; //minutes

            //JWTAuth::factory()->setTTL($myTTL);
            $token = $JWTAuth->attempt($credentials,['exp' => Carbon::now()->addDays(1)->timestamp]);

            if(!$token) {
                $users = User::where("email",$request->email)->get()->toArray(); 
                   if(count($users)>0){
                    return response()
                            ->json([
                                'status' => 'fail',
                                'token' => $token,
                                'msg' => 'Incorrect Password '
                            ]);
                } else {
                   return response()
                            ->json([
                                'status' => 'fail',
                                'token' => $token,
                                'msg' => 'Please Register yourself '
                            ]);
                }

               // throw new AccessDeniedHttpException();
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
