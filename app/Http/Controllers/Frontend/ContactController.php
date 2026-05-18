<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Models\BulkQuoteRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'enquiry_type' => 'nullable|string|max:255',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'message'      => 'nullable|string|max:2000',
        ]);

        ContactEnquiry::create([
            'enquiry_type' => $request->enquiry_type,
            'name'         => $request->name,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'message'      => $request->message,
            'status'       => 'new',
            'admin_notes'  => null,
        ]);

        return back()->with('success', 'Thank you! Your enquiry has been submitted successfully.');
    }

    public function quickStore(Request $request)
{
    $request->validate([
        'enquiry_type' => 'nullable|string|max:255',
        'full_name'    => 'required|string|max:255',
        'phone'        => 'required|string|max:20',
        'email'        => 'nullable|email|max:255',
        'city'         => 'nullable|string|max:255',
        'message'      => 'required|string|max:2000',
    ]);

    $messageParts = [];

    if ($request->city) {
        $messageParts[] = 'City / Premises: ' . $request->city;
    }

    if ($request->message) {
        $messageParts[] = 'Message: ' . $request->message;
    }

    ContactEnquiry::create([
        'enquiry_type' => $request->enquiry_type ?? 'Quick Enquiry Popup',
        'name'         => $request->full_name,
        'phone'        => $request->phone,
        'email'        => $request->email,
        'message'      => implode("\n", $messageParts),
        'status'       => 'new',
        'admin_notes'  => null,
    ]);

    return back()->with('success', 'Thank you! Your enquiry has been submitted successfully.');
}


 public function bulkstore(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'city'         => 'nullable|string|max:255',
            'notes'        => 'nullable|string|max:2000',
        ]);

        BulkQuoteRequest::create([
            'product'      => 'Quick Enquiry',
            'variant'      => null,
            'qty'          => null,
            'company_name' => $request->company_name,
            'city'         => $request->city,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'notes'        => $request->notes,
            'status'       => 'new',
            'admin_notes'  => null,
        ]);

        return back()->with('success', 'Thank you! Your enquiry has been submitted successfully.');
    }
}