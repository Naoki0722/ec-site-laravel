<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('images')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'product_id' => 1,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'product_id' => 2,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'product_id' => 2,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'product_id' => 2,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 7,
                'product_id' => 3,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/6-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 8,
                'product_id' => 3,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/6-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 9,
                'product_id' => 3,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/5-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 10,
                'product_id' => 3,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/5-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 11,
                'product_id' => 4,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 12,
                'product_id' => 4,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 13,
                'product_id' => 4,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/8-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 14,
                'product_id' => 5,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-1.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 15,
                'product_id' => 5,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-2.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 16,
                'product_id' => 5,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 17,
                'product_id' => 6,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 18,
                'product_id' => 7,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 19,
                'product_id' => 8,
                'image_url' => 'https://tokuda-ec-site.s3-ap-northeast-1.amazonaws.com/7-3.JPG',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
