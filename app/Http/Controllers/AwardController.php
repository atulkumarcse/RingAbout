<?php

namespace App\Http\Controllers;

use App\Award;
use Illuminate\Http\Request;
use Validator;
use Session;
use Intervention\Image\Facades\Image as Image;

use Tymon\JWTAuth\JWTAuth;

use Dingo\Api\Routing\Helpers;

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JWTAuth $JWTAuth , Request $request) 
    {
       $currentUser = $JWTAuth->parseToken()->authenticate();
       $award = new Award();
       $award->name = $request->name;
       $award->bank_name = $request->bank_name;
       $award->bank_acc = $request->bank_acc;
       $award->user_id = $currentUser->id;
       $award->info = $request->info;
       $award->save();
         return response()->json([
                'status' => "ok"
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function show(Award $award)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function edit(Award $award)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Award $award)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function destroy(Award $award)
    {
        //
    }
}
