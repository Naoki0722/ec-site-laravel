<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesTableSeeder extends Seeder
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
            'name' => 'ピアス',
            'description' => 'あくまでテストです',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => 2,
            'name' => 'リング',
            'description' => 'あくまでテストです',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 3,
            'name' => '指輪',
            'description' => 'これはあくまでテストですので関係ないです',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 4,
            'name' => '修理',
            'description' => 'これはあくまでテストですので関係ないです',
        ];
        DB::table('categories')->insert($param);
    }
}
