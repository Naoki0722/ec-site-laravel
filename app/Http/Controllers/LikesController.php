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
        try {
            $items = DB::table('likes')
                        ->select('user_id', 'category_name', 'title', 'price')
                        ->Join(DB::raw('(select products.id as id, categories.name as category_name, title, products.description, price from products join categories on categories.id=products.category_id) as products'), 'likes.product_id', '=', 'products.id')
                        ->where('user_id', $request->user_id)
                        ->get();
            $message = 'DB connected & like_info successfully got';
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
        $now = Carbon::now();
        $like = Like::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        if (empty($like)) {            
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
        } else {
            return response()->json([
                'message' => 'warning! like is exists!'
            ]);
        }
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
        try {
            // $item = Like::where('user_id', $like->user_id)->where('product_id', $like->product_id)->delete();
            $item = Like::where('id', $like->id)->delete();
            $message = 'DB connected & likes successfully deleted';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message
            ], $status);
        }
    }
}
