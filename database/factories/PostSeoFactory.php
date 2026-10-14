<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostSeo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostSeo>
 */
class PostSeoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'meta_title' => fake()->sentence(6),
            'meta_description' => fake()->sentence(18),
            'og_image' => null,
            'canonical_url' => null,
            'robots_index' => true,
            'robots_follow' => true,
        ];
    }
}
