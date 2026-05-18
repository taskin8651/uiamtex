<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UpgradeRequest;
use Illuminate\Http\Request;

class UpgradeExtinguisherController extends Controller
{
    public function index()
    {
        return view('frontend.upgrade_your_extinguisher');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user'                       => 'required|string|max:255',
            'phone'                      => 'required|string|max:20',
            'email'                      => 'nullable|email|max:255',
            'city'                       => 'nullable|string|max:255',
            'current_extinguisher_type'  => 'nullable|string|max:255',
            'capacity'                   => 'nullable|string|max:100',
            'premises_type'              => 'nullable|string|max:255',
            'qty'                        => 'nullable|integer|min:1|max:9999',
            'message'                    => 'nullable|string|max:2000',
        ]);

        $messageParts = [];

        if ($request->capacity) {
            $messageParts[] = 'Capacity: ' . $request->capacity;
        }

        if ($request->premises_type) {
            $messageParts[] = 'Premises Type: ' . $request->premises_type;
        }

        if ($request->message) {
            $messageParts[] = 'Notes: ' . $request->message;
        }

        UpgradeRequest::create([
            'user'                      => $request->user,
            'current_extinguisher_type' => $request->current_extinguisher_type,
            'qty'                       => $request->qty ?? 1,
            'city'                      => $request->city,
            'phone'                     => $request->phone,
            'email'                     => $request->email,
            'message'                   => implode("\n", $messageParts),
            'status'                    => 'new',
            'admin_notes'               => null,
        ]);

        return back()->with('success', 'Thank you! Your upgrade request has been submitted successfully.');
    }
}