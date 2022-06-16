<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
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
        /**
         * Users
         */
        DB::table('users')->insert([
            'given_name' => 'Mario',
            'family_name' => 'Mario',
            'email' => 'mario@bros.com',
            'birth_date' => '1981-01-01',
            'password' => Hash::make('password'),
            'address_id' => 1,
        ]);

        DB::table('users')->insert([
            'given_name' => 'Luigi',
            'family_name' => 'Mario',
            'email' => 'luigi@bros.com',
            'password' => Hash::make('password'),
        ]);

        /**
         * Address
         */
        DB::table('addresses')->insert([
            'street' => 'Via Vai 12',
            'city' => 'Milano',
            'postal_code' => '20125',
            'country_code' => 'IT',
            'user_id' => 1,
        ]);

        /**
         * Post
         */
        DB::table('posts')->insert([
            'title' => Str::random(5),
            'body' => Str::random(6).' '.Str::random(7),
            'status' => 'offline',
        ]);

        /**
         * Comments
         */
        DB::table('comments')->insert([
            'text' => Str::random(3).' '.Str::random(4),
            'post_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('comments')->insert([
            'text' => Str::random(4),
            'post_id' => 1,
            'user_id' => 2,
        ]);
    }
}
