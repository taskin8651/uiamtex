<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Categories (only active)
        $categories = BlogCategory::query()
            ->where('is_active', 'yes')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        // Base posts query (only published + category active)
        $postsQuery = BlogPost::query()
            ->with(['select_category'])
            ->where('is_published', 'yes')
            ->whereHas('select_category', function ($q) {
                $q->where('is_active', 'yes');
            });

        // Optional: search by title/excerpt
        if ($request->filled('q')) {
            $q = trim($request->q);
            $postsQuery->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('excerpt', 'like', "%{$q}%");
            });
        }

        // Optional: filter by category slug
        if ($request->filled('category')) {
            $catSlug = trim($request->category);
            $postsQuery->whereHas('select_category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Optional: sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $postsQuery->orderBy('published_at', 'asc');
        } else {
            // latest default
            $postsQuery->orderBy('published_at', 'desc');
        }

        // Featured post (latest published)
        $featuredPost = (clone $postsQuery)->first();

        // Posts list (exclude featured from grid)
        $posts = $postsQuery
            ->when($featuredPost, function ($q) use ($featuredPost) {
                $q->where('id', '!=', $featuredPost->id);
            })
            ->paginate(8)
            ->withQueryString();

        return view('frontend.blog', compact('categories', 'featuredPost', 'posts'));
    }

    // We'll build this next (blog detail page)
   public function show($slug)
    {
        $post = BlogPost::query()
            ->with(['select_category'])
            ->where('is_published', 'yes')
            ->where('slug', $slug)
            ->whereHas('select_category', function ($q) {
                $q->where('is_active', 'yes');
            })
            ->firstOrFail();

        // Related posts (same category, exclude current)
        $relatedPosts = BlogPost::query()
            ->with(['select_category'])
            ->where('is_published', 'yes')
            ->where('select_category_id', $post->select_category_id)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.blog_detail', compact('post', 'relatedPosts'));
    }

}
