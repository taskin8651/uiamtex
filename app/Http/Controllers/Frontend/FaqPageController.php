<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;

class FaqPageController extends Controller
{
    public function index()
    {
        // Load only active categories + only active faqs
        $categories = FaqCategory::query()
            ->where('is_active', 'yes')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->with(['faqs' => function ($q) {
                $q->where('is_active', 'yes')
                  ->orderBy('sort_order', 'asc')
                  ->orderBy('id', 'desc');
            }])
            ->get();

        // Flat list also useful for search (optional)
        $faqs = $categories->flatMap(fn ($c) => $c->faqs)->values();

        return view('frontend.faq', compact('categories', 'faqs'));
    }
}
