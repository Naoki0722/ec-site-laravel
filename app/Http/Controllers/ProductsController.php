<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

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
                    'id' => $product->id,
                    'category_name' => $product->category->name,
                    'product_name' => $product->title,
                    'price' => $product->price,
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
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // // 商品登録(productsテーブルへインサート)
            $now = Carbon::now();
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->created_at = $now;
            $product->updated_at = $now;
            $product->save();


            // 画像をひとまずs3へ
            $images = $request->image_url;
            foreach ($images as $image) {
                list(, $fileData) = explode(';', $image);
                list(, $fileData) = explode(',', $fileData);
                $fileData = base64_decode($fileData);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_buffer($finfo, $fileData);
                $extensions = [
                    'image/gif' => 'gif',
                    'image/jpeg' => 'jpeg',
                    'image/png' => 'png',
                ];
                // ランダムなファイル名 + 拡張子
                $random_str = Str::random(10); // 保存新ファイル名(ランダム生成)
                $fileName = $random_str . '.' . $extensions[$mime_type];
                Storage::disk('s3')->put($fileName, $fileData);
                $image_paths[] = Storage::disk('s3')->url($fileName);
            }

            // 画像登録(imagesテーブルへインサート)
            foreach ($image_paths as $image_path) {
                $image = new Image;
                $image->product_id = $product->id;
                $image->image_url = $image_path;
                $image->save();
            }
            $message = 'DB connected & product created!';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'product_data' => $product,
            'image_data' => $image,
            'message' => $message
        ], $status);
        
    }

    public function getAll()
    {
        try {
            $items = Product::all();
            $data =[];
            foreach($items as $item) {
                $data[] = [
                    'category_id' => $item->category->id,
                    'category_name' => $item->category->name,
                    'product_id' => $item->id,
                    'product_name' => $item->title,
                    'description' => $item->description,
                    'price' => $item->price,
                    'image_url' => $item->images()->select('image_url')->get()->toArray()
                ];
            }
            $message = 'productsList successfully get';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG';
            $status = 500;
        }
        return response()->json([
            'data' => $data,
            'message' => $message
        ],$status);
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
                    'category_id' => $product->category->id,
                    'category_name' => $product->category->name,
                    'product_name' => $product->title,
                    'description' => $product->description,
                    'price' => $product->price,
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product, $category)
    {
        try {
            // 商品テーブル情報の変更
            $now = Carbon::now();
            $product = Product::where('id', $product)->where('category_id', $category)->first();
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->updated_at = $now;
            $product->save();

            // 画像テーブルの情報を変更するが一度画像を消して再度入れ直す方法

            $message = 'DB connected & product successfully updated!';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'data' => $product,
            'message' => $message
        ], $status);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($category, $product)
    {
        // テーブルはもちろん、S3からも消す。
        try {
            Product::where('category_id', $category)->where('id',$product)->delete();
            $images = Image::where('product_id', $product)->select('image_url')->get();
            foreach ($images as $image) {
                $split = explode('com/', $image->image_url);
                $fileName = $split[1];
                Storage::disk('s3')->delete($fileName);
            }
            Image::where('product_id', $product)->delete();
            $message = 'DB connected & product successfully deleted!';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'data' => $product,
            'message' => $message
        ], $status);
    }
}
