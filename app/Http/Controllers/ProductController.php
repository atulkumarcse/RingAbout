<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use Session;
use Intervention\Image\Facades\Image as Image;


class ProductController extends Controller
{
    public function index()

    {
        $uid = Session()->get('uid');
        $products = Product::where("id",$uid)->latest()->paginate(5);
        
        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

     public function user()

    {
        
        $uid = Session()->get('uid');
        $products = Product::where("id","!=",$uid)->latest()->paginate(5);
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
         if (empty($request->file)  && empty($request->detail))  {
        // get the error messages from the validator
        $messages = "Please Enter Details or select File";
        return redirect()->route('products.create')
            ->withErrors($messages);
    }
    dd($request->file->getClientOriginalName());
         $product = new Product();
        $product->name = $request->name;
         $product->detail = $request->detail;
          if ($request->hasFile('file')) {
        $destinationPath = public_path('images');
        $images = $request->file->getClientOriginalName();
        $fileName = time().'_'.$images; // Add current time before image name
        $imageResize     = Image::make($request->file->getRealPath())
                   ->resize(500,500,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
       $filepath        = "public/images/".$fileName;

       $product->url = $filepath;
    }
         $product->user_id = Session()->get('uid');
         $product->save();
        //Product::create($request->all());

     

        return redirect()->route('products.index')

                        ->with('success','Product created successfully.');

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

      $val = Product::where('id', $id)->update(['status' => $status]);
      
       return redirect()->route('products.index')

                        ->with('success','Product Status Changed.');

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
