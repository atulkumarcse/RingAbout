<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use Session;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        Session()->flashInput($request->input());
        $uid = Session()->get('uid');
        $products = Product::where("user_id",$uid)->where("status",1)->latest()->paginate(5);
        
        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

     public function user(Request $request) {
        Session()->flashInput($request->input());
        $uid = Session()->get('uid');
        $products = Product::where("user_id","!=",$uid)->where("status","!=",0)->latest()->paginate(5);
        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }



     public function yourclassified(Request $request) {
        Session()->flashInput($request->input());
        $uid = Session()->get('uid');
        $products = Product::where("user_id",$uid)->where("status",2)->latest()->paginate(5);
        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
       
        return view('products.create');

    }

    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
         if (($request->file === null)  || empty($request->detail))  {
        // get the error messages from the validator
        $messages = "Please select advertisement and select File";
        return redirect()->route('products.create')
            ->withErrors($messages);
    }
    //dd($request->file->getClientOriginalName());
         $product = new Product();
        $product->name = $request->name;
         $product->detail = $request->detail;
          if ($request->hasFile('file')) {
        $destinationPath = public_path('images');
        $images = $request->file->getClientOriginalName();
        $fileName = time().'_'.$images; // Add current time before image name
        //$imageResize     = Image::make($request->file->getRealPath())
                   //->resize(2080,2080,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
        // $imageResize     = Image::make($request->file->getRealPath())->save($destinationPath.'/'.$fileName); 
        $request->file->move('public/images',$fileName); 
       $filepath        = "public/images/".$fileName;

       $product->url = $filepath;
    }
         $product->user_id = Session()->get('uid');
         $product->save();
        //Product::create($request->all());

     

        return redirect()->route('products.index')

                        ->with('success','Advertisement created successfully.');

    }


    public function authstore(Request $request) {
    //$currenUser = $JWTAuth->parseToken()->authenticate();
    $uid = Session()->get('uid');
    if((!($request->get('detail')) && !($request->hasFile('file')))){
      return $this->response->error($request->all() , 422);
    }
  //'Please fill the all the details',
     if(!$request->get('name')){
        $names = "Any";
       } else {
        $names = $request->get('name');
       }
    $product = new Product();
    $product->name = $names;
     if ($request->hasFile('file')) {
        $destinationPath = public_path('images');
        $images = $request->file->getClientOriginalName();
        $fileName = time().'_'.$images; // Add current time before image name

        //$imageResize     = Image::make($request->file->getRealPath())
          //           ->save($destinationPath.'/'.$fileName);  
       $request->file->move('public/images',$fileName);
       $filepath        = "public/images/".$fileName;
       $product->url = $filepath;
    } else {
       $product->detail = $request->get('detail');
    }
    $product->status = 2;
    $product->user_id = $uid ; 
    
    if ($product->save()) {
      return response()->json([
                'status' => 'true',
                'msg'=>"Advertise Created Successfully"
            ], 200);
    }
    return response()->json([
                'status' => 'false',
                'msg'=>"could not create advertise"
            ], 500);
  }
  
  public function authAdvertiseStorepattern(Request $request) {
     $uid = Session()->get('uid');
    //$currenUser = $JWTAuth->parseToken()->authenticate();
    if((!($request->get('detail')) )){
      return $this->response->error($request->all() , 422);
    }
  //'Please fill the all the details',
     if(!$request->get('name')){
        $names = "Any";
       } else {
        $names = $request->get('name');
       }
    $product = new Product();
    $product->detail = $request->get('detail');
    $product->name = $names;
     if (!empty($request->file)) {
       $filepath        = $request->file;
       $product->url = $filepath;
    } else {
       $product->url = 'http://imaegodigital.com/RingAbout/assets/SVG/bubbles.svg';
    }
    $product->status = 2;
    $product->user_id = $uid ; 
    
    if ($product->save()) {
      return response()->json([
                'status' => 'true',
                'msg'=>"Advertise Created Successfully"
            ], 200);
    }
    return response()->json([
                'status' => 'false',
                'msg'=>"could not create advertise"
            ], 500);
  }

     

    /**

     * Display the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function show(Product $product)
    {  
          
        return view('products.show',compact('product'));

    } 


     public function status(Request $request, $id ,  $status)
    {  
      $statusarray = array(2 => "Approved" ,  3 =>"Rejected" , 0 => "Deleted");
      $val = Product::where('id', $id)->update(['status' => $status]);
      
       return redirect()
                        ->back()
                        ->with('success',"Classified ". $statusarray[$status]);

    } 

     

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit(Product $product )

    {
        
        return view('products.edit',compact('product'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Product $product)

    {

        $request->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);

    

        $product->update($request->all());

    

        return redirect()->route('products.index')

                        ->with('success','Product updated successfully');

    }

    

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy(Product $product)

    {

        $product->delete();

    

        return redirect()->route('products.index')

                        ->with('success','Product deleted successfully');

    }


}
