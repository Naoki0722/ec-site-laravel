<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([CategoriesTableSeeder::class],[ProductsTableSeeder::class], [ImagesTableSeeder::class], [LikeTableSeeder::class]);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(LikeTableSeeder::class);
    }
}
