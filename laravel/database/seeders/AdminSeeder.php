<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'phu@gmail.com',
            'password' => Hash::make('123'), 
            'phone' => '0123456789',
            'role' => 'super_admin', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
