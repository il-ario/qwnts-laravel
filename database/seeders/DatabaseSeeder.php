<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            'password' => Hash::make('Password1.'),
            'address_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'given_name' => 'Luigi',
            'family_name' => 'Mario',
            'email' => 'luigi@bros.com',
            'password' => Hash::make('Password1.'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        /**
         * Post
         */
        DB::table('posts')->insert([
            'title' => Str::random(5),
            'body' => Str::random(6).' '.Str::random(7),
            'status' => 'offline',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        /**
         * Comments
         */
        DB::table('comments')->insert([
            'text' => Str::random(3).' '.Str::random(4),
            'post_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('comments')->insert([
            'text' => Str::random(4),
            'post_id' => 1,
            'user_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
