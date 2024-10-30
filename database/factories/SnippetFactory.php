<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Snippet;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Snippet>
 */
class SnippetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'body_html' => '<p>'.fake()->paragraph().'</p>',
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Snippet $snippet) {
            // ...
        })->afterCreating(function (Snippet $snippet) {
            // attach a few random tags
            $tag_ids = Tag::inRandomOrder()->limit(rand(3,6))->pluck('id');
            $snippet->tags()->attach($tag_ids);
        });
    }
}
