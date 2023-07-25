<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([

            //Me
            [
                'id' => '13',
                'name' => 'ken',
                'username' => 'ken',
                'email' => 'kensan@gmail.com',
                'password' => Hash::make(12345678),
                'role' => 'admin',
            ]



        ]);
    }
}
