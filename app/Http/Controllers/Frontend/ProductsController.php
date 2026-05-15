<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Product listing page
     * URL: /products or /products/category/{slug}
     */
    public function index(Request $request, $categorySlug = null)
    {
        $categories = Category::query()
            ->where('is_active', '1')
            ->orderBy('sort_order')
            ->get();

        $query = Product::query()
            ->with(['select_category'])
            ->where('is_active', 'yes');

        // optional category filter
        $activeCategory = null;
        if (!empty($categorySlug)) {
            $activeCategory = Category::query()
                ->where('slug', $categorySlug)
                ->where('is_active', '1')
                ->firstOrFail();

            $query->where('select_category_id', $activeCategory->id);
        }

        // sorting
        // supported: recommended | price_low | price_high
        $sort = $request->get('sort', 'recommended');

        if ($sort === 'price_low') {
            // base_price is likely stored as string - keep safe cast
            $query->orderByRaw('CAST(base_price AS DECIMAL(10,2)) ASC');
        } elseif ($sort === 'price_high') {
            $query->orderByRaw('CAST(base_price AS DECIMAL(10,2)) DESC');
        } else {
            // recommended = featured first then newest
            $query->orderByRaw("CASE WHEN is_featured='yes' THEN 0 ELSE 1 END ASC")
                  ->orderByDesc('id');
        }

        $products = $query->paginate(12)->withQueryString();

        return view('frontend.product_all', compact(
            'products',
            'categories',
            'activeCategory',
            'sort'
        ));
    }

    /**
     * Product detail page
     * URL: /product/{slug}
     */
    public function show(string $slug)
    {
        $product = Product::query()
            ->with([
                'select_category',
                'variants' => function ($q) {
                    $q->orderByRaw("CASE WHEN is_default = 'yes' THEN 0 ELSE 1 END")
                      ->orderBy('id', 'asc');
                },
                'images', // ProductImage models (each has media collection "image")
            ])
            ->where('slug', $slug)
            ->where('is_active', 'yes')
            ->firstOrFail();

        // Flatten gallery images from ProductImage media collection
        $gallery = collect();
        foreach ($product->images as $imgRow) {
            // ProductImage::getImageAttribute returns a Media collection
            if (!empty($imgRow->image) && $imgRow->image->count()) {
                $gallery = $gallery->merge($imgRow->image);
            }
        }

        // Fallback to main_image if product_images gallery is empty
        if ($gallery->isEmpty() && $product->main_image) {
            $gallery = collect([$product->main_image]);
        }

        // Select current/default variant (if exists)
        $currentVariant = $product->variants->firstWhere('is_default', 'yes') ?? $product->variants->first();

        // Decide which price to show initially (variant price wins)
        $price = $currentVariant?->price ?? $product->base_price;
        $comparePrice = $currentVariant?->compare_price ?? $product->compare_price;

        return view('frontend.product_detail', compact(
            'product',
            'gallery',
            'currentVariant',
            'price',
            'comparePrice'
        ));
    }
}