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
            'name' => 'ピアス',
            'description' => 'あくまでテストです',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'リング',
            'description' => 'あくまでテストです',
        ];
        DB::table('categories')->insert($param);
    }
}
