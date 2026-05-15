<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\HomeHero;
use App\Models\SiteSetting;
use App\Models\WorkGallery;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Category;
use App\Models\Certification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Site settings
        $siteSetting = SiteSetting::query()->first();

        // Home Hero Slides
        $homeHeroes = HomeHero::query()
            ->where('is_active', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Active values support (yes / 1 / true variations)
        $activeYes = ['yes', 'YES', 'Yes', 1, '1', true, 'true'];

        // Work Gallery (Active only)
        $workGalleries = WorkGallery::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Clients (Active only) - ordered by sort_order
        $clients = Client::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderByRaw("CASE WHEN sort_order IS NULL OR sort_order = '' THEN 999999 ELSE sort_order END ASC")
            ->orderBy('id', 'asc')
            ->get();

        // Latest Blog Posts (Published only + Category active)
        $latestBlogPosts = BlogPost::query()
            ->with(['select_category'])
            ->where('is_published', 'yes')
            ->whereHas('select_category', function ($q) {
                $q->where('is_active', 'yes');
            })
            ->orderByRaw("CASE WHEN published_at IS NULL THEN 1 ELSE 0 END")
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        // Home FAQ Preview (Active only) - show 3
        $homeFaqs = Faq::query()
            ->with(['select_category:id,name'])
            ->where('is_active', 'yes')
            ->whereHas('select_category', function ($q) {
                $q->where('is_active', 'yes');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        // Featured Products Section
        $featuredProducts = Product::query()
            ->with(['select_category'])
            ->where('is_active', 'yes')
            ->where('is_featured', 'yes')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        // Featured Filters (chips)
        $featuredCategoryIds = $featuredProducts
            ->pluck('select_category_id')
            ->filter()
            ->unique()
            ->values();

        $featuredCategories = Category::query()
            ->where('is_active', 'yes')
            ->when($featuredCategoryIds->count() > 0, function ($q) use ($featuredCategoryIds) {
                $q->whereIn('id', $featuredCategoryIds);
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->limit(3)
            ->get();

        // Certifications (Active only)
        $certifications = Certification::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.index', compact(
            'siteSetting',
            'homeHeroes',
            'workGalleries',
            'clients',
            'latestBlogPosts',
            'homeFaqs',
            'featuredProducts',
            'featuredCategories',
            'certifications'
        ));
    }
}