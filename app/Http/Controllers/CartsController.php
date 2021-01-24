<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Image;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // carts?user_id=○でリクエストする
    public function index(Request $request)
    {
        $items = Cart::where('user_id', $request->user_id)->get();
        return response()->json([
            'data' => $items,
            'message' => 'cart info is got!'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now();
        $product = Product::where('id', $request->product_id)->first();
        $image = Image::where('product_id', $request->product_id)->first();
        $item = new Cart;
        // もし既にカートにデータがあればinsertできないように弾く必要あり
        $item->user_id = $request->user_id;
        $item->product_id = $request->product_id;
        $item->title = $product->title;
        $item->price = $product->price;
        $item->image_url = $image->image_url;
        $item->created_at = $now;
        $item->updated_at = $now;
        $item->save();
        return response()->json([
            'data' => $item,
            'message' => 'cart is created!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    
    //api/carts/カートidを入れればいい
    public function destroy(Request $request)
    {
        Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->delete();
        return response()->json([
            // 'data' => $cart,
            'message' => 'cart is deleted!'
        ], 200);
    }
}
