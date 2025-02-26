<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sets')->insert([
            'user_id' => 1, // References the user created in UserSeeder
            'title' => 'English Vocabulary',
            'description' => 'Basic English vocabulary flashcards',
            'visibility' => 'public',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
