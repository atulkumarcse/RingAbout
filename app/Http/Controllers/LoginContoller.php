<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\User;

class LoginContoller extends Controller
{
    public function login()
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);
         if ($validator->fails()) {
                // get the error messages from the validator
                $messages = $validator->messages();
                // redirect our user back to the form with the errors from the validator
                return redirect()->route('leaderboards.create')
                    ->withErrors($validator);
            }

        $user = User::where("password",Hash::make($request->password))->andwhere("email",$request->email)->get();
        if($user->count > 0 ){
            return view('leaderboards.index',compact('leaderboards'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        } else {
           return redirect()->route('/')
            ->withErrors("Please Register yourself");
        }    

        
    }
}
