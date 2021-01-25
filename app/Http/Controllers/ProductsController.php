<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category)
    {
        // Eloquentの混合の書き方 Products hasMany Image    Image belongsTo Productsの概念は後ほど考える。
        try {
            $items = Product::select('products.id', 'category_id', 'title', 'description', 'price', 'image_url')
                            ->leftJoin('images', 'products.id', '=', 'images.product_id')
                            ->where('category_id', $category)
                            ->get();
            $message = 'DB connected & product_info successfully got';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $items,
                'message' => $message
            ], $status);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($category, $product)
    {
        // リクエストに応じ、カテゴリーに該当する商品だけを取得するクエリのメモ
        try {
            $items = DB::table('products')
                        ->select('products.id', 'category_id', 'title', 'description', 'price', 'image_url')
                        ->leftJoin('images', 'products.id', '=', 'images.product_id')
                        ->where('category_id', $category)
                        ->where('product_id', $product)
                        ->get();
            $message = 'DB connected & product_info successfully got';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $items,
                'message' => $message
            ], $status);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
