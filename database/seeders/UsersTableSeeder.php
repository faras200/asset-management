<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Farras',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'code' => 'HDN0001',
            'alamat' => 'Jl. Peta Barat Kalideres No. 1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
