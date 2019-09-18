<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Customer;
use App\Category;
use App\Product;
use Session;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart= null;
        if( !Session::has('cart') || empty( Session::get('cart')->getContents()) ){
            return redirect('products')->with('message','No products in the cart');
        }

        $cart = Session::get('cart');
        return view('products.checkout',compact('cart'));
        
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
    public function store(Request $request)
    {

        $cart= [];
        $order = "";
        $checkout = "";
        if( Session::has('cart') ){
            $cart = Session::get('cart');
        }

        if( $request->shippingAddressSame){
            $customer = [
            "billingFirstName"  => $request-> billingFirstName,
            "billingLastName"  => $request-> billingLastName,
            "billingUserName"  => $request-> billingUserName,
            "billingEmail"  => $request-> billingEmail,
            "billingAddressOne"  => $request-> billingAddressOne,
            "billingAddressTwo"  => $request-> billingAddressTwo,
            "billingCountry"  => $request-> billingCountry,
            "billingState"  => $request-> billingState,
            "billingZip"  => $request-> billingZip,

            "shippingFirstName"  => $request-> shippingFirstName,
            "shippingLastName"  => $request-> shippingLastName,
            "shippingAddressOne"  => $request-> shippingAddressOne,
            "shippingAddressTwo"  => $request-> shippingAddressTwo,
            "shippingCountry"  => $request-> shippingCountry,
            "shippingState"  => $request-> shippingState,
            "shippingZip"  => $request-> shippingZip,
            ];
   
        }else{
            $customer = [
                "billingFirstName"  => $request-> billingFirstName,
                "billingLastName"  => $request-> billingLastName,
                "billingUserName"  => $request-> billingUserName,
                "billingEmail"  => $request-> billingEmail,
                "billingAddressOne"  => $request-> billingAddressOne,
                "billingAddressTwo"  => $request-> billingAddressTwo,
                "billingCountry"  => $request-> billingCountry,
                "billingState"  => $request-> billingState,
                "billingZip"  => $request-> billingZip,
            ];
        }

        DB::beginTransaction();
        $checkout = Customer::create($customer);
        foreach( $cart->getContents() as $slug => $product){
            $products = [
                'user_id' => $checkout->id,
                'product_id' => $product['product']->id,
                'qty' => $product['qty'],
                'status' =>'pending',
                'price' => $product['price'],
                'payment_id' => 0,
            ];
            $order = Order::create($products);
        }

        if($checkout && $order){
            DB::commit();
            return view('products.payment');
        }else{
            DB::rollback();
            return redirect('checkout')->with('message','Invalid activity');
        }

        



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
