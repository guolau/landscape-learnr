<?php

namespace Database\Factories;

use App\Models\TagCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tag_category_id = TagCategory::inRandomOrder()->first()->id;

        return [
            'tag_category_id' => rand(0,100) > 20 ? $tag_category_id : null,
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(8),
        ];
    }
}
