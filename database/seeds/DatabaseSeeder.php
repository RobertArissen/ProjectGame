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
            'coins' => 100,
            'password' => Hash::make('123')
        ]);

        /* Seed Peroid */
        DB::table('periods')->insert([
            'name' => '476 n.Chr.',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

         /* Seed Houses */
         DB::table('buildings')->insert([
            'name' => 'Gebouw 1',
            'price' => 50,
            'periods_id' => 1,
            'index' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('buildings')->insert([
            'name' => 'Gebouw 2',
            'price' => 110,
            'periods_id' => 1,
            'index' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('buildings')->insert([
            'name' => 'Kasteel',
            'price' => 90,
            'periods_id' => 1,
            'index' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('buildings')->insert([
            'name' => 'Gebouw 3',
            'price' => 150,
            'periods_id' => 1,
            'index' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
