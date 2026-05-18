<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AmcEnquiry;
   use App\Models\FaqCategory;

use Illuminate\Http\Request;

class AmcController extends Controller
{

public function index()
{
    $amcFaqCategory = FaqCategory::query()
        ->with(['faqs' => function ($query) {
            $query->where('is_active', 'yes')
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc');
        }])
        ->where('is_active', 'yes')
        ->where('name', 'LIKE', '%AMC%')
        ->orderBy('sort_order', 'asc')
        ->first();

    $amcFaqs = $amcFaqCategory ? $amcFaqCategory->faqs : collect();

    return view('frontend.support-amc', compact('amcFaqs'));
}

    public function store(Request $request)
    {
        $request->validate([
            'user'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|max:255',
            'city'      => 'nullable|string|max:255',
            'site_type' => 'nullable|string|max:255',
            'plan_type' => 'nullable|string|max:255',
            'quantity'  => 'nullable|string|max:100',
            'fire_type' => 'nullable|string|max:255',
            'message'   => 'nullable|string|max:2000',
        ]);

        $messageParts = [];

        if ($request->quantity) {
            $messageParts[] = 'Approx Quantity: ' . $request->quantity;
        }

        if ($request->fire_type) {
            $messageParts[] = 'Extinguisher Type: ' . $request->fire_type;
        }

        if ($request->message) {
            $messageParts[] = 'Requirement: ' . $request->message;
        }

        AmcEnquiry::create([
            'user'        => $request->user,
            'plan_type'   => $request->plan_type,
            'city'        => $request->city,
            'site_type'   => $request->site_type,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'message'     => implode("\n", $messageParts),
            'status'      => 'new',
            'admin_notes' => null,
        ]);

        return back()->with('success', 'Thank you! Your AMC enquiry has been submitted successfully.');
    }
}