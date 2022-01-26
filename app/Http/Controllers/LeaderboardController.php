<?php

namespace App\Http\Controllers;

use App\Leaderboard;
use Illuminate\Http\Request;
use Validator;
use Session;

use Tymon\JWTAuth\JWTAuth;

use Dingo\Api\Routing\Helpers;

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Intervention\Image\Facades\Image as Image;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(JWTAuth $JWTAuth)
    {
        //
         $currentUser = $JWTAuth->parseToken()->authenticate();
         $leaderboards = Leaderboard::where('status',"!=",0)->latest()->paginate(10000);
         return response()->json([
                'status' => true,
                'msg'=>"leaderboard list",
                'data'=>$leaderboards
            ], 200);
    }

    public function index()
    {
        //
        $leaderboards = Leaderboard::where('status',"!=",0)->orderBy('order', 'ASC')->paginate(5);
    
        return view('leaderboards.index',compact('leaderboards'))

            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function leaderboarddata()
    {
        //
        $leaderboards = Leaderboard::where('status',"!=",0)->orderBy('order', 'ASC')->paginate(10000);
    
        return response()->json([
                'status' => true,
                'msg'=>"leaderboard list",
                'data'=>$leaderboards
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leaderboards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'money' => 'required'
        ]);
         if ($validator->fails()) {

        // get the error messages from the validator
        $messages = $validator->messages();
        // redirect our user back to the form with the errors from the validator
        return redirect()->route('leaderboards.create')
            ->withErrors($validator);

    }
         $leaderboard = new Leaderboard();
         
         $leaderboard->name = $request->name;
         $leaderboard->money = $request->money;
         $leaderboard->save();
        //Product::create($request->all());

     

        return redirect()->route('leaderboards.index')

                        ->with('success','Leaderboard created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function show(Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leaderboard $leaderboard)
    {
        //
    }

    public function status(Request $request, $id ,  $status)
    {  

      $val = Leaderboard::where('id', $id)->update(['status' => $status]);
      
       return redirect()->route('leaderboards.index')

                        ->with('success','Leaderboard Deleted.');

    }
    public function updateOrder(Request $request)
    {
        $leaderboards = Leaderboard::all();

        foreach ($leaderboards as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    } 
}
