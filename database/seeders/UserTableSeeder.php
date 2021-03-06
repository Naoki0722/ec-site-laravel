<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'nao',
                'email' => 'test@test.com',
                'tell_number' => '00012340000',
                'role' => 5,
                'user_id' => 'tttttteeeseefdsaf',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'eri',
                'email' => 'test1@test.com',
                'tell_number' => '0133339455',
                'role' => 10,
                'user_id' => 'tttttt3feaeeeseefdsaf',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'tokuda',
                'email' => 'test2@test.com',
                'tell_number' => '0001122340000',
                'role' => 10,
                'user_id' => 't9dfdftteeeseefdsaf',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
