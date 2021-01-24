<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // ユーザーに紐づくお気に入り一覧を表示する
    // api/likes?user_id=○でリクエスト
    public function index(Request $request)
    {


        //商品テーブルのデータ
        // $item = DB::table('products')
        //                 ->select('products.id','category_id','title','description','price','image_url')
        //                 ->Join('images', 'products.id', '=', 'images.product_id');

        // $products = DB::table('categories')
        //                 ->select('products.id', 'categories.name as category_name', 'title', 'products.description as product_description', 'price','image_url')
        //                 ->JoinSub($item, 'products', 'categories.id' , 'products.category_id')
        //                 ->get();

        // $items = DB::table('users')
        //             ->select('likes.id','name', 'category_name', 'title', 'product_description','image_url')
        //             ->leftJoin('likes', 'users.id', '=', 'likes.user_id')
        //             ->leftJoinSub($products, 'products', 'likes.product_id', 'products.id')
        //             ->where('user_id' , $request->user_id)
        //             ->get();


        $items = DB::table('likes')
                    ->select('user_id', 'category_name','title','price')
                    ->Join(DB::raw('(select products.id as id, categories.name as category_name, title, products.description, price from products join categories on categories.id=products.category_id) as products'), 'likes.product_id','=', 'products.id')
                    ->where('user_id' , $request->user_id)
                    ->get();

        return response()->json([
            'data' => $items,
            'message' => 'like_info get'
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
        $item = new Like;
        $item->user_id = $request->user_id;
        $item->product_id = $request->product_id;
        $item->created_at = $now;
        $item->updated_at = $now;
        $item->save();
        return response()->json([
            'data' => $item,
            'message' => 'user is liked'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        $item = Like::where('user_id', $like->user_id)->where('product_id', $like->product_id)->delete();
        return response()->json([
            'message' => 'like is deleted'
        ], 200);
    }
}
