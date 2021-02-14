<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => 1,
            'category_id' => 1,
            'title' => 'クロスシルバーピアス',
            'description' => '小さいながらもお洒落なデザインのピアスです、シルバー色なので普段の生活でつけていても目立ちすぎず、お洒落にすることができますよ！',
            'price' => 2000,
        ];
        DB::table('products')->insert($param);

        $param = [
            'id' => 2,
            'category_id' => 2,
            'title' => 'スモールゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 15000,
        ];
        $param = [
            'id' => 3,
            'category_id' => 2,
            'title' => 'ゴールドリング(テスト)',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 4,
            'category_id' => 3,
            'title' => 'レインボーネックレス',
            'description' => '虹色に輝くレインボーのピアスです、高級だけど絶対似合う！虹色に輝くレインボーのピアスです、高級だけど絶対似合う！虹色に輝くレインボーのピアスです、高級だけど絶対似合う！虹色に輝くレインボーのピアスです、高級だけど絶対似合う！',
            'price' => 12000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 5,
            'category_id' => 2,
            'title' => 'シルバーゴールドリング',
            'description' => '光り輝くリングで高級感がすごいです。光り輝くリングで高級感がすごいです。光り輝くリングで高級感がすごいです。光り輝くリングで高級感がすごいです。光り輝くリングで高級感がすごいです。光り輝くリングで高級感がすごいです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 6,
            'category_id' => 2,
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5400,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 7,
            'category_id' => 1,
            'title' => 'ゴールドピアス',
            'description' => '光り輝くゴールドでとても綺麗で鮮やかなピアスです。光り輝くゴールドでとても綺麗で鮮やかなピアスです。光り輝くゴールドでとても綺麗で鮮やかなピアスです。光り輝くゴールドでとても綺麗で鮮やかなピアスです。',
            'price' => 2300,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 8,
            'category_id' => 3,
            'title' => 'レトロネックレス',
            'description' => 'レトロな昔懐かしのネックレス、流行とは逆らっているけど、なぜかつけたくなるような外観です！レトロ好きにはぴったりな商品です高級だけど絶対似合う！',
            'price' => 12000,
        ];
        DB::table('products')->insert($param);
    }
}
