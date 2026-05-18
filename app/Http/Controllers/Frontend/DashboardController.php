<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\EndUser;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $endUser = EndUser::firstOrCreate(
            ['email' => $user->email],
            [
                'name'     => $user->name,
                'phone'    => '',
                'password' => $user->password,
                'status'   => 'active',
            ]
        );

        $recentOrders = Order::with(['user'])
            ->where('user_id', $endUser->id)
            ->with(['items.product'])
            ->latest()
            ->take(3)
            ->get();

        $addresses = Address::where('user_id', $endUser->id)
            ->latest()
            ->take(2)
            ->get();

        $wishlists = Wishlist::with('product')
            ->where('user_id', $endUser->id)
            ->latest()
            ->take(2)
            ->get();

        $allOrders = Order::where('user_id', $endUser->id);

        $totalOrders = (clone $allOrders)->count();
        $activeOrders = (clone $allOrders)
            ->whereIn('status', ['processing', 'shipped', 'hold'])
            ->count();
        $inTransitOrders = (clone $allOrders)->where('status', 'shipped')->count();
        $totalSpend = (clone $allOrders)
            ->where(function ($query) {
                $query->whereNull('status')->orWhere('status', '!=', 'cancelled');
            })
            ->sum('total');

        return view('frontend.dashboard', compact(
            'user',
            'endUser',
            'recentOrders',
            'addresses',
            'wishlists',
            'totalOrders',
            'activeOrders',
            'inTransitOrders',
            'totalSpend'
        ));
    }
}
