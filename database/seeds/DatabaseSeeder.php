<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* Seed Class */
        DB::table('class')->insert([
            'name' => '1B',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('class')->insert([
            'name' => '3F',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('class')->insert([
            'name' => '2C',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        /* Seed Users */
        User::create([
            'name' => 'Robert Arissen',
            'email' => 'robert.arissen@student.hu.nl',
            'class_id' => 1,
            'password' => Hash::make('123')
        ]);
    }
}
