<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);
        $published = fake()->boolean(65);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),

            'title' => $title,
            'slug' => Str::slug($title),

            'excerpt' => fake()->paragraph(),

            'content' => collect(
                fake()->paragraphs(5)
            )->map(
                fn (string $paragraph) =>
                    '<p>' . e($paragraph) . '</p>'
            )->implode("\n"),

            'featured_image' => null,

            'status' => $published
                ? 'published'
                : 'draft',

            'is_featured' => false,

            'published_at' => $published
                ? fake()->dateTimeBetween('-3 months', 'now')
                : null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
            'is_featured' => false,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function featured(): static
    {
        return $this->published()->state(
            fn (array $attributes) => [
                'is_featured' => true,
            ]
        );
    }
}
