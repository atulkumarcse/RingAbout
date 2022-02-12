<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Request;
use Intervention\Image\Facades\Image as Image;

//use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        try
            {
            $usersa = $user->save();
            }
            catch(Exception $e)
            {
               return response()->json([
                'status' => 'false',
                'msg'=>"Integrity constraint violation"
            ], 500);
            }
        
        if(!empty($usersa->error)) {
            //throw new HttpException(500);
             return response()->json([
                'status' => 'false',
                'msg'=>"Integrity constraint violation"
            ], 500);

        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function userProfile(Request $request, JWTAuth $JWTAuth , $userid)
    {
         $currentUser = $JWTAuth->parseToken()->authenticate();
         $challenges = User::where('id',$userid)->get()->toArray();
         return response()->json([
                'status' => true,
                'msg'=>"challenge list",
                'data'=>$challenges
            ], 200);
    }

    public function userList(Request $request){
        $UserList = User::select('id','name')->get()->toArray();
         return response()->json([
                'status' => true,
                'msg'=>"user list",
                'data'=>$UserList
            ], 200);
    }


    public function userstatus(Request $request, JWTAuth $JWTAuth , $key, $status)
    {
           $currentUser = $JWTAuth->parseToken()->authenticate();
         
             try { 
             $challenges = User::find($currentUser->id);
             $challenges->$key = $status ;  
             $challenges->save();
             } catch(Exception $e) {
                   return response()->json([
                    'status' => 'false',
                    'msg'=>"Integrity constraint violation"
                ], 500);
             }
             return response()->json([
                    'status' => true,
                    'msg'=>"challenge list",
                    'data'=>$challenges
                ], 200);
    }

    public function updateProfile(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $othersvalue = "";
        $currentUser = $JWTAuth->parseToken()->authenticate();
        $others = $request->get("others");
        if($others){
        if(count($others)>0){
           foreach ($others as $key => $value) {

                  $othersvalue .= $value.",";
            }   
        }else {
            $othersvalue = "";
        }
        } else {
             $othersvalue = "";
        }
        $user = User::find($currentUser->id);
        try
            {
            if ($request->hasFile('file')) {
                $destinationPath = public_path('images');
                $images = $request->file->getClientOriginalName();
                $fileName = time().'_'.$images; // Add current time before image name
                $imageResize     = Image::make($request->file->getRealPath())
                           ->resize(500,500,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
               $filepath        = "public/images/".$fileName;
               $user->url = $filepath;
            }    
            $user->name =  $request->name;
            $user->user_name =  $request->user_name;
            $user->zip_code =  $request->zip_code;
            $user->email =  $request->email;
            $user->twitter =  $othersvalue;
            $usersa = $user->save();
            }
            catch(Exception $e)
            {
               return response()->json([
                'status' => 'false',
                'msg'=>"Integrity constraint violation"
            ], 500);
            }
        
        if(!empty($usersa->error)) {
            //throw new HttpException(500);
             return response()->json([
                'status' => 'false',
                'msg'=>"Integrity constraint violation"
            ], 500);

        }

        return response()->json([
            'status' => 'ok',
            'msg' => "Update Successfully",
            'user' => $user

        ], 201);
    }
}
