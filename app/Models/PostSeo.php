<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['post_id', 'meta_title', 'meta_description', 'og_image', 'canonical_url', 'robots_index', 'robots_follow'])]
class PostSeo extends Model
{
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ];
    }
}
