<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        // Optional: If you store HTML in content, we will render it safely via {!! !!}
        return view('frontend.pages', compact('page'));
    }
}
