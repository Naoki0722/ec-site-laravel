<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{


    //※ここは私のクエリテスト遊び場です...※
    public function sample()
    {


        // $categories = Category::all();
        // $data=[];
        // foreach ($categories as $category) {
        //     $data[] =[
        //         'category' => $category->name,
        //         'product' => $category->products()->select('title', 'description', 'price')->get()->toArray(),
        //         'image' => $category->images()->select('image_url')->get()->toArray(),

        //     ];
        // }
        
        // return response()->json([
        //     'data' => $data
        // ] ,200);

        // １対多でアクセス
        // $products = Product::with('images')->where('id', '1')->get();
        // $data = [];
        // foreach($products as $product) {
        //     $data[] = [
        //         // productsテーブル - title
        //         'title' => $product->title,
        //         'price' => $product->price,
        //         'image' => $product->images()->select('image_url')->get()->toArray()
        //     ];
        // }
        // return response()->json([
        //     'data' => $products
        // ] ,200);

        // 多対1でアクセス
        // $images = Image::all();
        // $data = [];
        // foreach ($images as $image) {
        //     $data[] = [
        //         // commentsテーブル - comment
        //         'image' => $image->image_url,
        //         // membersテーブル - name
        //         'name'  => $image->product->title,
        //     ];
        // }
        // return response()->json([
        //     'data' => $data
        // ], 200);


        // 多対1でアクセス
        // $images = Image::with('product')->get();
        // $data = [];
        // foreach ($images as $image) {
        //     $data[] = [
        //         'image' => $image->image_url,
        //         // membersテーブル - name
        //         'name'  => $image->product->title,
        //     ];
        // }
        // return response()->json([
        //     'data' => $data
        // ], 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // api/categories/{category}/products
    public function index($category)
    {
 
        try {
            $products = Product::where('category_id', $category)
                            ->with(['category','images'])
                            ->get();
            $data = [];
            foreach($products as $product) {
                $data[] = [
                    'category_name' => $product->category->name,
                    'product_name' => $product->title,
                    'image_url' => $product->images()->select('image_url')->get()->toArray()
                ];
            }
            $message = 'DB connected & product_info successfully got';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $status);


        // Eloquentの混合の書き方
        // try {
        //     $items = Product::select('products.id', 'category_id', 'title', 'description', 'price', 'image_url')
        //                     ->leftJoin('images', 'products.id', '=', 'images.product_id')
        //                     ->where('category_id', $category)
        //                     ->get();
        //     $message = 'DB connected & product_info successfully got';
        //     $status = 200;
        // } catch (\Throwable $th) {
        //     $message = 'ERROR DB connection NG ';
        //     $status = 500;
        // } finally {
        //     return response()->json([
        //         'data' => $items,
        //         'message' => $message
        //     ], $status);
        // }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 画像のS3へのアップロード
        // 複数画像は配列にて格納されているものと仮定し、foreachで回してデータを格納し、1個ずつS3に保存する。
        // 保存したURLをデータベースに格納する
        $file_name = $request->image;
        $file_name = preg_replace('/^data:image.*base64,/', '', $file_name);
        $file_name = str_replace('', '+', $file_name);
        $image = base64_decode($file_name);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $image);
        $extensions = [
            'image/gif' => 'gif',
            'image/jpeg' => 'jpeg',
            'image/png' => 'png',
        ];
        $random_str = Str::random(10); // 保存新ファイル名(ランダム生成)
        $filename = $random_str . '.' . $extensions[$mime_type];
        Storage::disk('s3')->put($filename, $image);
        $image_path = Storage::disk('s3')->url($filename);


        // 商品登録(productsテーブルへインサート)
        $now = Carbon::now();
        $product = new Product;
        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->created_at = $now;
        $product->updated_at = $now;
        $product->save();

        // 画像登録(imagesテーブルへインサート)
        $image = new Image;
        $image->product_id = $product->id;
        $image->image_url = $image_path;
        $image->save();

        return response()->json([
            'product_data' => $product,
            'image_data' => $image,
            'message' => 'product created!'
        ] , 200);

        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($category, $product)
    {

        // リクエストに応じ、カテゴリーに該当する商品だけを取得するクエリ
        try {
            $products = Product::where('category_id', $category)
                            ->where('id', $product)
                            ->with(['category','images'])
                            ->get();
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    'category_name' => $product->category->name,
                    'product_name' => $product->title,
                    'image_url' => $product->images()->select('image_url')->get()->toArray()
                ];
            }
            $message = 'DB connected & product_info successfully got';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $status);


        // リクエストに応じ、カテゴリーに該当する商品だけを取得するクエリのメモ
        // try {
        //     $items = DB::table('products')
        //                 ->select('products.id', 'category_id', 'title', 'description', 'price', 'image_url')
        //                 ->leftJoin('images', 'products.id', '=', 'images.product_id')
        //                 ->where('category_id', $category)
        //                 ->where('product_id', $product)
        //                 ->get();
        //     $message = 'DB connected & product_info successfully got';
        //     $status = 200;
        // } catch (\Throwable $th) {
        //     $message = 'ERROR DB connection NG ';
        //     $status = 500;
        // } finally {
        //     return response()->json([
        //         'data' => $items,
        //         'message' => $message
        //     ], $status);

        // }

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
