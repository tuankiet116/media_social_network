<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('films')->insert([
            'user_id' => User::where('email', 'kietdat1612000@gmail.com')->first()->id,
            'src' => "",
            'thumbnail_src' => ""
        ]);
    }
}
