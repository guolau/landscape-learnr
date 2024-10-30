<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Snippet;
use App\Models\TagCategory;
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

        TagCategory::factory()
            ->count(7)
            ->create();

        Tag::factory()
            ->count(75)
            ->create();

        Snippet::factory()
            ->count(55)
            ->has(StreetViewLink::factory()->count(2))
            ->has(Image::factory()->count(1))
            ->create();
    }
}
