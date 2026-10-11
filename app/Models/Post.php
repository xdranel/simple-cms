<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'status', 'is_featured','published_at'])]
class Post extends Model
{
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function relatedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_relations', 'post_id', 'related_post_id');
    }

    public function seo(): HasOne
    {
        return $this->hasOne(PostSeo::class);
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
