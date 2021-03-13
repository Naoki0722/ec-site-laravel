<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //画像だけを商品編集画面で登録する
        try {
            $image = $request->image_url;
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
            $image_path = Storage::disk('s3')->url($fileName);

            // 画像登録(対象商品に紐づけてimagesテーブルへインサート)
            $images = new Image;
            $now = Carbon::now();
            $images->product_id = $request->product_id;
            $images->image_url = $image_path;
            $images->created_at = $now;
            $images->updated_at = $now;
            $images->save();

            $message = 'DB connected & product created!';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'image_data' => $images,
            'message' => $message
        ], $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $image)
    {
        // テーブルはもちろん、S3からも消す。
        try {
            $image = Image::where('id', $image)->first();
            $split = explode('com/', $image->image_url);
            $fileName = $split[1];
            Storage::disk('s3')->delete('/',$fileName);
            Image::where('product_id', $image->product_id)->where('id', $image->id)->delete();
            $message = 'DB connected & product successfully deleted!';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        }
        return response()->json([
            'message' => $message
        ], $status);
    }
}
