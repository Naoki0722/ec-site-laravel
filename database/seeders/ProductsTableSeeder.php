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
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        $param = [
            'id' => 3,
            'category_id' => 3,
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 4,
            'category_id' => 4,
            'title' => 'レインボーピアス',
            'description' => '虹色に輝くレインボーのピアスです、高級だけど絶対似合う！',
            'price' => 12000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 5,
            'category_id' => 2,
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 6,
            'category_id' => 1,
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 7,
            'category_id' => 1,
            'title' => 'ゴールドリング',
            'description' => '光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。光り輝くゴールドのリングです。',
            'price' => 5000,
        ];
        DB::table('products')->insert($param);
        $param = [
            'id' => 8,
            'category_id' => 1,
            'title' => 'レインボーピアス',
            'description' => '虹色に輝くレインボーのピアスです、高級だけど絶対似合う！',
            'price' => 12000,
        ];
        DB::table('products')->insert($param);
    }
}
