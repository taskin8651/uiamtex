<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return (float) $item['price'] * (int) $item['quantity'];
        });

        $totalItems = collect($cart)->sum('quantity');

        return view('frontend.cart', compact('cart', 'subtotal', 'totalItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer',
            'quantity'   => 'required|integer|min:1|max:999',
        ]);

        $product = Product::query()
            ->with(['select_category'])
            ->where('id', $request->product_id)
            ->where('is_active', 'yes')
            ->firstOrFail();

        $variant = null;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::where('id', $request->variant_id)
                ->where('product_id', $product->id)
                ->first();
        }

        $price = $variant?->price ?? $product->base_price ?? 0;
        $comparePrice = $variant?->compare_price ?? $product->compare_price ?? null;

        $image = null;

        if ($product->main_image) {
            $image = $product->main_image->url ?? null;
        }

        if (!$image) {
            $image = asset('assets/img/product/product-1.png');
        }

        $variantText = null;

        if ($variant) {
            $parts = [];

            if (!empty($variant->capacity)) {
                $parts[] = $variant->capacity;
            }

            if (!empty($variant->finish)) {
                $parts[] = $variant->finish;
            }

            $variantText = implode(' / ', $parts);
        }

        $cart = session()->get('cart', []);

        $cartKey = $product->id . '_' . ($variant?->id ?? 'default');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$cartKey] = [
                'cart_key'      => $cartKey,
                'product_id'    => $product->id,
                'variant_id'    => $variant?->id,
                'name'          => $product->name,
                'slug'          => $product->slug,
                'category'      => $product->select_category->name ?? 'Product',
                'variant_text'  => $variantText,
                'image'         => $image,
                'price'         => (float) $price,
                'compare_price' => $comparePrice ? (float) $comparePrice : null,
                'quantity'      => (int) $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('message', 'Product added to cart successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            $cart[$request->cart_key]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('message', 'Cart updated successfully.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('message', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('message', 'Cart cleared successfully.');
    }
}