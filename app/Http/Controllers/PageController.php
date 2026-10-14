<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->withCount([
                'posts' => fn ($query) => $query->where('status', 'published'),
            ])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->limit(3)
            ->get();

        $featuredPosts = Post::query()
            ->with(['category', 'user'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->limit(4)
            ->get();

        if ($featuredPosts->isEmpty()){
            $featuredPosts = Post::query()
                ->with(['category', 'user'])
                ->where('status', 'published')
                ->latest()
                ->limit(4)
                ->get();
        }

        return view('pages.welcome', compact('categories', 'featuredPosts'));
    }
}
