<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EndUser;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('message', 'Please login first to continue checkout.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('message', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
        });

        $shipping = 0;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        return view('frontend.checkout', compact(
            'cart',
            'subtotal',
            'shipping',
            'tax',
            'total'
        ));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('message', 'Please login first to place your order.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('message', 'Your cart is empty.');
        }

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'company'         => 'nullable|string|max:255',
            'gst_no'          => 'nullable|string|max:50',
            'address'         => 'required|string|max:1000',
            'city'            => 'required|string|max:255',
            'state'           => 'required|string|max:255',
            'pincode'         => 'required|string|max:20',
            'notes'           => 'nullable|string|max:1000',
            'payment_gateway' => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = collect($cart)->sum(function ($item) {
                return (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
            });

            $shipping = 0;
            $tax = 0;
            $total = $subtotal + $shipping + $tax;

            $addressSnapshot = [
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'company' => $request->company,
                'gst_no'  => $request->gst_no,
                'address' => $request->address,
                'city'    => $request->city,
                'state'   => $request->state,
                'pincode' => $request->pincode,
                'notes'   => $request->notes,
            ];

            /*
             |--------------------------------------------------------------------------
             | Important
             |--------------------------------------------------------------------------
             | orders.user_id ka foreign key end_users.id se linked hai.
             | Auth::id() users table ka id deta hai, isliye FK error aata tha.
             | Yaha checkout form email se EndUser find/create karke uska id save hoga.
             */

            $endUser = EndUser::where('email', $request->email)->first();

            if (!$endUser) {
                $endUser = EndUser::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'phone'    => $request->phone,
                    'password' => bcrypt('password'),
                ]);
            } else {
                $endUser->update([
                    'name'  => $request->name,
                    'phone' => $request->phone,
                ]);
            }

            $order = Order::create([
                'user_id'          => $endUser->id,
                'order_no'         => $this->generateOrderNumber(),
                'status'           => 'processing',
                'subtotal'         => $subtotal,
                'shipping'         => $shipping,
                'tax'              => $tax,
                'total'            => $total,
                'payment_status'   => 'pending',
                'payment_gateway'  => $request->payment_gateway,
                'txn'              => null,
                'address_snapshot' => json_encode($addressSnapshot),
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'] ?? null,
                    'variant_id'    => $item['variant_id'] ?? null,
                    'qty'           => (int) ($item['quantity'] ?? 1),
                    'price'         => (float) ($item['price'] ?? 0),
                    'meta_snapshot' => json_encode([
                        'name'          => $item['name'] ?? null,
                        'slug'          => $item['slug'] ?? null,
                        'category'      => $item['category'] ?? null,
                        'variant_text'  => $item['variant_text'] ?? null,
                        'image'         => $item['image'] ?? null,
                        'compare_price' => $item['compare_price'] ?? null,
                    ]),
                ]);
            }

            session()->forget('cart');

            DB::commit();

            return redirect()
                ->route('checkout.success', $order->order_no)
                ->with('message', 'Order placed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'order' => $e->getMessage(),
                ]);
        }
    }

    private function generateOrderNumber()
    {
        $year = date('Y');

        $lastOrder = Order::withTrashed()
            ->where('order_no', 'LIKE', 'ORD-' . $year . '-%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder && !empty($lastOrder->order_no)) {
            $lastNumber = (int) substr($lastOrder->order_no, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'ORD-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}