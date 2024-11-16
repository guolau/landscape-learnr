<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Snippet;
use App\Models\TagCategory;
use App\Models\Tag;
use App\Models\StreetViewLink;
use App\Models\Image;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds used for automated tests. Creates minimal DB records for 
     * faster test performance.
     */
    public function run(): void
    {
        User::factory()->create([
            'is_admin' => true,
        ]);
        
        User::factory()
            ->count(2)
            ->create([
                'is_admin' => false,
            ]);

        TagCategory::factory()
            ->count(2)
            ->create();

        Tag::factory()
            ->count(15)
            ->create();

        Snippet::factory()
            ->count(5)
            ->has(StreetViewLink::factory()->count(2))
            ->has(Image::factory()->count(1))
            ->create();
    }
}
