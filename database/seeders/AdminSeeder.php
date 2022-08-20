<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'email' => 'kietdat1612000@gmail.com',
            'password' => bcrypt('admin123'),
            'role_id' => 1,
            'name' => 'Super Admin'
        ]);
    }
}
