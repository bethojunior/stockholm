<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('user_types')->insert([
            [
                'id' => 1,
                'name' => 'super_admin'
            ],
            [
                'id' => 2,
                'name' => 'admin'
            ],
            [
                'id' => 3,
                'name' => 'costumer'
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@teste.com',
                'password' => Hash::make('admin12'),
                'user_type_id' => 1,
            ],
            [
                'name' => 'Betho',
                'email' => 'betho@teste.com',
                'password' => Hash::make('admin12'),
                'user_type_id' => 2,
            ]
        ]);

    }
}
