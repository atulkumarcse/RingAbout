<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use Session;

class ProductController extends Controller
{
    public function index()

    {
        //Session::set('uid', 1);
        Session()->put('uid', 1);
        $products = Product::latest()->paginate(5);
        
    

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
       
      
        // $request->validate([

        //     'name' => 'required', 

        //     'detail' => 'required',

        // ]); 'image' => 'mimes:jpeg,bmp,png',

               $validator = Validator::make($request->all(),[
            'name' => 'required',
            'detail' => 'required'
        ]);
         if ($validator->fails()) {

        // get the error messages from the validator
        $messages = $validator->messages();

        // redirect our user back to the form with the errors from the validator
        return redirect()->route('products.create')
            ->withErrors($validator);

    }
         $product = new Product();
        $product->name = $request->name;
         $product->detail = $request->detail;
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
