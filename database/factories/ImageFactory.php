<?php

namespace Database\Factories;

use App\Models\Image;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alt_text' => fake()->sentence(),
            'attribution' => fake()->sentence(),
            'license' => fake()->text(10),
            'license_url' => fake()->url(),
            'source_url' => fake()->url(),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Image $image) {
            // ...
        })->afterCreating(function (Image $image) {
            // get and store random image
            $path = collect(glob('db-seed-images/*'))->random();
            $image->storeFile(file_get_contents($path), basename($path));
        });
    }
}
