<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Cart;
use Session;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(3);
        return view('admin.products.index',compact('products'));
    }

    public function trash(){
        $products = Product::onlyTrashed()->paginate(3);
        return view('admin.products.index',compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $extension = ".".$request->thumbnail->getClientOriginalExtension();
        $name = basename($request->thumbnail->getClientOriginalName(),$extension).time();
        $name = $name . $extension;
        $path = 'images/'.$name;
        $request->thumbnail->move(public_path('images'), $name);
        $product = Product::create([
            'title' => $request->title,
            'slug'  => $request->slug,
            'description' => $request->description,
            'thumbnail' => $path,
            'status'    => $request->status,
            'options'   => isset( $request->extras) ? json_encode( $request->extras) : null,
            'featured'  => ($request->featured) ? $request->featured : 0,
            'price'     => $request->price,
            'discount' => ($request->discount) ? $request->discount : 0,
            'discount_price' => ($request->discount_price) ? $request->discount_price : 0,
        ]);

        if( $product ){
            $product->categories()->attach($request->category_id );
            return back()->with('message','Product Successfully Added');
        }else{
            return back()->with('message','Error Inserting Product');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
        $products = Product::all();
        $categories = Category::all();
        return view('products.all',compact('products','categories'));
    }

    public function addToCart(Product $product, Request $request){

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $qty = $request->qty ? $request->qty :1 ;
        $cart = new Cart( $oldCart );
        $cart->addProduct( $product , $qty );
        Session::put('cart', $cart );
        //Session::flush();
        return back()->with('message','Product Added Successfully.');
    }

    public function cart(){
        $categories = Category::all();
        if( !Session::has('cart') ){
            $cart = '';
            return view('products.cart',compact('cart','categories'));
        }

        $cart = Session::get('cart');
        return view('products.cart',compact('cart','categories'));
        
    }

    public function removeProduct(Product $product){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart( $oldCart );
        $cart->removeProduct( $product );
        Session::put('cart', $cart );
        //Session::flush();
        return back()->with('message','Product Removed Successfully.');
    }
    public function updateProduct(Product $product, Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart( $oldCart );
        $cart->updateProduct( $product, $request->qty );
        Session::put('cart', $cart );
        //Session::flush();
        return back()->with('message','Product Updated Successfully.');
    }

    public function single(Product $product){
        $categories = Category::all();
        return view('products.single',compact('product','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.create',['product'=>$product,'categories'=>$categories]);
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
        if( $request->has('thumbnail') ){
            $image_path = $product->thumbnail; 
            if(file_exists($image_path)) {
                @unlink($image_path);
            }
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(),$extension).time();
            $name = $name . $extension;
            $path = 'images/'.$name;
            $product->thumbnail = $path;
            $request->thumbnail->move(public_path('images'), $name);
             
            
        }


            $product->title = $request->title;
            $product->slug  = $request->slug;
            $product->description = $request->description;
            $product->status    = $request->status;
            $product->featured  = ($request->featured) ? $request->featured : 0;
            $product->price    = $request->price;
            $product->discount = ($request->discount) ? $request->discount : 0;
            $product->discount_price = ($request->discount_price) ? $request->discount_price : 0;

            $product->categories()->detach();

            if( $product->save() ){
                $product->categories()->attach( $request->category_id);
                return back()->with('message','Product Successfully Updated');
            }else{
                return back()->with('message','Error updating record');
            }
    
    
        }

        public function recoverProduct( $id ){
            $product = Product::onlyTrashed()->findOrFail($id);
            if($product->restore()){
                return back()->with('message','Product Successfully Restored');
            }else{
                return back()->with('message','Error Restoring Product ');
            }
        }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
     if( $product->categories()->detach() && $product->forceDelete() ){
         //Storage::disk('public')->delete( $product->thumbnail);
         $image_path = $product->thumbnail;  // Value is not URL but directory file path
         if(file_exists($image_path)) {
            @unlink($image_path);
         }

         return back()->with('message','Product Successfully Deleted');
     }else{
        return back()->with('message','Error deleting record');
     }
    }

    public function remove(Product $product){
        if( $product->delete()){
            return back()->with('message','Product Successfully Trashed');
        }else{
            return back()->with('message','Error trashing record');
        }
    }
}
