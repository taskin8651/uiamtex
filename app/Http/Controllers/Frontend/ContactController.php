<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
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
}