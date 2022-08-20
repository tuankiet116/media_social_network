<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Do Tuan Kiet',
                'email' => 'kietdat1612000@gmail.com',
                'password' => bcrypt('tuankiet123'),
                'is_has_page' => 0
            ]
        );
    }
}
