<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('users')->insert([
            [
                'id' => 1,
                'first_name' => 'Tom',
                'last_name' => 'Jerry',
                'email' => 'tom_and_jerry@gmail.com',
                'password' => app('hash')->make('1234567'),
                'phone' => '+380 (50) 123-45-67',
            ], [
                'id' => 2,
                'first_name' => 'Tony',
                'last_name' => 'Stark',
                'email' => 'tony_stark@gmail.com',
                'password' => app('hash')->make('1234567'),
                'phone' => '+380 (50) 123-45-67',
            ]
            ]);
    }
}
