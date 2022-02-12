<?php

namespace App\Http\Controllers;

use App\Challenge;
use Illuminate\Http\Request;
use Validator;
use Session;
use Intervention\Image\Facades\Image as Image;

use Tymon\JWTAuth\JWTAuth;

use Dingo\Api\Routing\Helpers;

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $challenges = Challenge::where('status',"!=",0)->latest()->paginate(5);
        
    

        return view('challenges.index',compact('challenges'))

            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function list(JWTAuth $JWTAuth)
    {
        //
         $currentUser = $JWTAuth->parseToken()->authenticate();
         $challenges = Challenge::where('status',"!=",0)->latest()->paginate(5);
         return response()->json([
                'status' => true,
                'msg'=>"challenge list",
                'data'=>$challenges
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     // dd($request->hasFile('file'));
    //      $validator = Validator::make($request->all(),[
    //         'name' => 'required',
    //         'detail' => 'required'
    //     ]);
    //      if ($validator->fails()) {

    //     // get the error messages from the validator
    //     $messages = $validator->messages();
    //     // redirect our user back to the form with the errors from the validator
    //     return redirect()->route('challenges.create')
    //         ->withErrors($validator);

    // }
         if (empty($request->file)  && empty($request->detail))  {
        // get the error messages from the validator
        $messages = "Please Enter Details or select File";
        return redirect()->route('challenges.create')
            ->withErrors($messages);
    }
    
         $challenge = new Challenge();
         if ($request->hasFile('file')) {
        $destinationPath = public_path('images');
        $images = $request->file->getClientOriginalName();
        $fileName = time().'_'.$images; // Add current time before image name
        $imageResize     = Image::make($request->file->getRealPath())
                   ->resize(2080,2080,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
       $filepath        = "public/images/".$fileName;
       $challenge->url = $filepath;
    }
         $challenge->name = $request->name;
         $challenge->detail = $request->detail;
         //$product->url = $request->detail;
         $challenge->user_id = Session()->get('uid');
         $challenge->save();
        //Product::create($request->all());

     

        return redirect()->route('challenges.index')

                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge , $id)
    {
        //
         $challenge = $challenge->find($id);
         return view('challenges.edit',compact('challenge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'detail' => 'required'
        ]);
         if ($validator->fails()) {

        // get the error messages from the validator
        $messages = $validator->messages();
        // redirect our user back to the form with the errors from the validator
        return redirect()->route('challenges.create')
            ->withErrors($validator);

    }
         $product = $challenge->find($id);
         if ($request->hasFile('file')) {
        $destinationPath = public_path('images');
        $images = $request->file->getClientOriginalName();
        $fileName = time().'_'.$images; // Add current time before image name
        $imageResize     = Image::make($request->file->getRealPath())
                   ->resize(500,500,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
       $filepath        = "public/images/".$fileName;
       $product->url = $filepath;
    }
         $product->name = $request->name;
         $product->detail = $request->detail;
         //$product->url = $request->detail;
         $product->user_id = Session()->get('uid');
         $product->save();
        //Product::create($request->all());

     

        return redirect()->route('challenges.index')

                        ->with('success','Challenge Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        //
    }

    public function status(Request $request, $id ,  $status)
    {  

      $val = Challenge::where('id', $id)->update(['status' => $status]);
      
       return redirect()->route('challenges.index')

                        ->with('success','Challenge Deleted.');

    } 
}
