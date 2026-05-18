<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DealershipApplication;
use Illuminate\Http\Request;

class DealershipController extends Controller
{
    public function index()
    {
        return view('frontend.dealership');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'              => 'required|string|max:255',
            'mobile'                 => 'required|string|max:20',
            'email'                  => 'nullable|email|max:255',
            'city_state'             => 'nullable|string|max:255',
            'business_type'          => 'nullable|string|max:255',
            'sales_focus'            => 'nullable|string|max:255',
            'experience'             => 'nullable|string|max:3000',
            'upload_gst'             => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5120',
            'upload_compay_profile'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,doc,docx|max:5120',
        ]);

        $application = DealershipApplication::create([
            'full_name'     => $request->full_name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'city_state'    => $request->city_state,
            'business_type' => $request->business_type,
            'sales_focus'   => $request->sales_focus,
            'experience'    => $request->experience,
            'status'        => 'new',
            'admin_notes'   => null,
        ]);

        if ($request->hasFile('upload_gst')) {
            $application
                ->addMediaFromRequest('upload_gst')
                ->toMediaCollection('upload_gst');
        }

        if ($request->hasFile('upload_compay_profile')) {
            $application
                ->addMediaFromRequest('upload_compay_profile')
                ->toMediaCollection('upload_compay_profile');
        }

        return back()->with('success', 'Thank you! Your dealership application has been submitted successfully.');
    }
}