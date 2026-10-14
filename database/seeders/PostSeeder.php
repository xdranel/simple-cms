<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostSeo;
use App\Models\Tag;
use App\Models\User;
use http\Exception\RuntimeException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::query()
            ->where('role', UserRole::Author->value)
            ->get();

        $categories = Category::all();
        $tags = Tag::all();

        if (
            $authors->isEmpty() ||
            $categories->isEmpty() ||
            $tags->isEmpty()
        ) {
            throw new RuntimeException(
                'Seed users, categories and tags first.'
            );
        }

        // 1. Create 20 posts.
        $posts = collect();

        for ($i = 0; $i < 20; $i++) {
            $post = Post::factory()->create([
                'user_id' => $authors->random()->id,
                'category_id' => $categories->random()->id,
            ]);

            // 2. Attach 1-4 random tags.
            $tagIds = $tags
                ->random(min(random_int(1, 4), $tags->count()))
                ->pluck('id')
                ->all();

            $post->tags()->sync($tagIds);

            // 3. Create SEO metadata.
            PostSeo::factory()->create([
                'post_id' => $post->id,
                'meta_title' => $post->title,
                'meta_description' => $post->excerpt,
            ]);

            $posts->push($post);
        }

        // 4. Mark up to 3 published posts as featured.
        $posts
            ->where('status', 'published')
            ->take(3)
            ->each(
                fn (Post $post) => $post->update([
                    'is_featured' => true,
                ])
            );

        // 5. Add 1-3 published related posts.
        $publishedPosts = $posts
            ->where('status', 'published');

        foreach ($posts as $post) {
            $candidates = $publishedPosts
                ->reject(fn (Post $related) =>
                    $related->id === $post->id
                );

            if ($candidates->isEmpty()) {
                continue;
            }

            $count = min(
                random_int(1, 3),
                $candidates->count()
            );

            $relatedIds = $candidates
                ->random($count)
                ->pluck('id')
                ->all();

            $post->relatedPosts()->sync($relatedIds);
        }
    }
}

