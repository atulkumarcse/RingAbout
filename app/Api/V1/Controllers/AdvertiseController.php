<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Book;
use App\Product;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use Intervention\Image\Facades\Image as Image;

class AdvertiseController extends Controller {

  use Helpers;

  public function index(JWTAuth $JWTAuth) {

    $currentUser = $JWTAuth->parseToken()->authenticate();

    $product = Product::orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
          return response()->json([
                'status' => 'true',
                'msg'=>"products list",
                'data'=>$product
            ], 200);          
  }

  public function store(Request $request, JWTAuth $JWTAuth) {
   
    $currenUser = $JWTAuth->parseToken()->authenticate();
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
        $imageResize     = Image::make($request->file->getRealPath())
                   ->resize(500,500,function($c){$c->aspectRatio(); $c->upsize();})->save($destinationPath.'/'.$fileName);  
       $filepath        = "public/images/".$fileName;
       $product->url = $filepath;
    } else {
       $product->detail = $request->get('detail');
    }
   
    $product->user_id = $currenUser->id ; 
    
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

  public function show($id, JWTAuth $JWTAuth) {

    $currentUser = $JWTAuth->parseToken()->authenticate();

    $book = $currentUser->books()->find($id);

    if (!$book) {
      throw new NotFoundHttpException;
    }

    return $book;
  }

  public function update(Request $request, $id, JWTAuth $JWTAuth) {

    $currentUser = $JWTAuth->parseToken()->authenticate();

    $book = $currentUser->books()->find($id);

    if (!$book) {
      throw new NotFoundHttpException;
    }

    $book->fill($request->all());

    if ($book->save()) {
      return $this->response->noContent();
    }

    return $this->response->error('could_not_update_book', 500);
  }

  public function destroy($id, JWTAuth $JWTAuth) {

    $currentUser = $JWTAuth->parseToken()->authenticate();

    $book = $currentUser->books()->find($id);

    if (!$book) {
      throw new NotFoundHttpException;
    }

    if ($book->delete()) {
      return $this->response->noContent();
    }

    return $this->response->error('could_not_delete_book', 500);
  }

}
