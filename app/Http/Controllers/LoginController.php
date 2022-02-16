<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\User;
use Hash;
use Auth;
use App\Mail\SendEmailDemo;
use Mail;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);
         if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                // redirect our user back to the form with the errors from the validator
                return redirect('/')
                    ->withErrors($messages);
            }
        $credentials = $request->only(['email', 'password']);
        $authcheck = Auth::attempt($credentials);
        if ( Auth::check() ){
            $user = Auth::user();
            if($user->status==2){
             Session()->put('uid', Auth::id());
             return redirect()->route('products.index')
                        ->with('success','Login Successfully');
            }else {
                return redirect('/')
            ->with("success","You are not valid User to Login");
            }
            
        } else {
           $user = User::where("email",$request->email)->get()->toArray(); 
           if(count($users)>0){
            return redirect('/')
            ->withErrors("Incorrect Password");
        } else {
           return redirect('/')
            ->withErrors("Please Register yourself");
        }
       }    

        
    }


    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
           return redirect('/')
            ->with('success',"Logout Successfully");
    }

    public function mailsend(Request $request){
       $useremail = $request->email;
       $password =str_random(6);  
      $user = User::where("email",$useremail)->get();
      $userd = User::find($user[0]->id);
      $userd->password = $password;
      $userd->save();
      if(count($user) > 0 ){
        
       $details = array('title' => "Login Credentials" ,"name" => ucfirst($user[0]->name) ,"email" =>$useremail, "username"=> $user[0]->username , "password"=>$password);
        $a =  Mail::send('mail', array("details"=>$details) , function ($message ) use ($useremail) {
    $message->from('atul.kumar@steponexp.com', 'Password change');
    $message->to($useremail)->subject('Login Credentials');

});
      return response()->json([
                'status' => "ok",
                'msg'=>"Msg Sent Successfully",
                'data'=>$user
            ], 200);
  }  else {
     return response()->json([
                'status' => "fail",
                'msg'=>"Please Register your self",
                'data'=>[]
            ], 200);

    }
  }
}
