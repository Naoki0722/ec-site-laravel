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
            'description' => 'あくまでテストですので、実際のピアスについての説明はもう少しあります。あくまでテストですので、実際のピアスについての説明はもう少しあります。あくまでテストですので、実際のピアスについての説明はもう少しあります。',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => 2,
            'name' => 'リング',
            'description' => 'あくまでテストですので、実際のリングについての説明はもう少しあります。あくまでテストですので、実際のリングについての説明はもう少しあります。あくまでテストですので、実際のリングについての説明はもう少しあります。',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 3,
            'name' => 'ネックレス',
            'description' => 'これはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないです',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 4,
            'name' => 'その他(修理)',
            'description' => 'これはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないですこれはあくまでテストですので関係ないです',
        ];
        DB::table('categories')->insert($param);
    }
}
