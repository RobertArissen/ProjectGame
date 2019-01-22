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
            'coins' => 400,
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

        /* Seed User Buildings */
        DB::table('users_buildings')->insert([
            'users_id' => 1,
            'periods_id' => 1,
            'building_id' => rand(1, 4),
            'x' => rand(0, 3),
            'y' => rand(0, 9),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users_buildings')->insert([
            'users_id' => 1,
            'periods_id' => 1,
            'building_id' => rand(1, 4),
            'x' => rand(7, 10),
            'y' => rand(0, 9),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('questionType')->insert([
            'name' => 'Sorteervraag',
            'inCode' => 'sort',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('questionType')->insert([
            'name' => 'Waar / Niet waar',
            'inCode' => 'tf',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('questionType')->insert([
            'name' => 'Multiple choice',
            'inCode' => 'mc',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('question')->insert([
            'name' => 'Sorteer de volgende gebeurtenissen op volgorde in tijd van verleden naar heden',
            'questionType_id' => 1,
            'period_id' => 1,
            'points' => 200,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('question')->insert([
            'name' => 'Leven wij nu in de Middeleeuwen?',
            'questionType_id' => 2,
            'period_id' => 1,
            'points' => 50,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('question')->insert([
            'name' => 'Wanneer waren de Middeleeuwen?',
            'questionType_id' => 3,
            'period_id' => 1,
            'points' => 100,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'kruistochten',
            'correct' => 1,
            'order' => 1,
            'question_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'Honderdjarige Oorlog',
            'correct' => 1,
            'order' => 2,
            'question_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'uitvinding van de boekdrukkunst',
            'correct' => 1,
            'order' => 3,
            'question_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'Waar',
            'correct' => 0,
            'order' => null,
            'question_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'Niet waar',
            'correct' => 1,
            'order' => null,
            'question_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'ca. 500 tot ca. 1500 n.Chr.',
            'correct' => 1,
            'order' => null,
            'question_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'ca. 500 voor tot ca. 500 n.Chr.',
            'correct' => 0,
            'order' => null,
            'question_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'ca. 1500 tot ca. 1700 n.Chr.',
            'correct' => 0,
            'order' => null,
            'question_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('answers')->insert([
            'name' => 'ca. 1500 tot ca. 500 v.Chr.',
            'correct' => 0,
            'order' => null,
            'question_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(VoyagerDummyDatabaseSeeder::class);
    }
}
