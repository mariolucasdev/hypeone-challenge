<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Chat::factory(1)->create();
        \App\Models\Message::factory(3)->create();

        \App\Models\User::factory()->create([
            'name' => 'Mário Lucas',
            'email' => 'mario@hypeone.com.br',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Michele',
            'email' => 'michele@hypeone.com.br',
        ]);
    }
}
