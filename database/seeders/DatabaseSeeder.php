<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'password' => '123456',
        ]);
        
        \App\Models\User::factory(50)->create();
        \App\Models\Post::factory(10)->create();
        \App\Models\Comment::factory(10)->create();

      
    }
}
