<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\User;
use Hash;
use Auth;

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
                    ->withErrors($validator);
            }
        $credentials = $request->only(['email', 'password']);
        $authcheck = Auth::attempt($credentials);
        if ( Auth::check() ){
             Session()->put('uid', Auth::id());
            return redirect()->route('products.index')
                        ->with('success','Login Successfully');
        } else {
           return redirect('/')
            ->withErrors("Please Register yourself");
        }    

        
    }
}
