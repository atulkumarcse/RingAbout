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
           return redirect('/')
            ->withErrors("Please Register yourself");
        }    

        
    }


    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
           return redirect('/')
            ->with('success',"Logout Successfully");
    }

    public function mailsend(){
      $password =  str_random(6);
      $details = array('title' => "Login Credentials" ,"name" => ucfirst("firstname") ,"email" =>"atulkumarit05@gmail.com", "username"=> "username" , "password"=>$password);
       $email = new SendEmailDemo($details);
       $email->to("atulkumarit05@gmail.com")->from("atul.kumar@steponexp.com")->subject("your password is here");


    }
}
