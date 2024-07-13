<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Snippet;
use App\Models\Tag;
use App\Models\StreetViewLink;
use App\Models\Image;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'email' => 'test@example.com',
            'password' => 'Test123',
            'is_admin' => true,
        ]);

        Snippet::factory()
            ->count(55)
            ->has(Tag::factory()->count(5))
            ->has(StreetViewLink::factory()->count(2))
            ->has(Image::factory()->count(1))
            ->create();
    }
}
