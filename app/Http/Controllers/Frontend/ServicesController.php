<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\Service;
use App\Models\ServiceEnquiry;
use App\Models\ServiceProcessStep;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $activeYes = ['yes', 'YES', 'Yes', 1, '1', true, 'true'];

        $services = Service::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->with(['features' => function ($q) {
                $q->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $industries = Industry::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // ✅ Service process steps (active only)
        $serviceProcessSteps = ServiceProcessStep::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.services', compact('services', 'industries', 'serviceProcessSteps'));
    }

    public function storeEnquiry(Request $request)
    {
        $validated = $request->validate([
            'premises_type'    => ['required', 'string', 'max:255'],
            'service_required' => ['required', 'string', 'max:255'],
            'name'             => ['required', 'string', 'max:255'],
            'phone'            => ['required', 'string', 'max:30'],
            'email'            => ['nullable', 'email', 'max:255'],
            'city'             => ['required', 'string', 'max:255'],
            'message'          => ['nullable', 'string', 'max:2000'],
        ]);

        ServiceEnquiry::create([
            'premises_type'    => $validated['premises_type'],
            'service_required' => $validated['service_required'],
            'name'             => $validated['name'],
            'phone'            => $validated['phone'],
            'email'            => $validated['email'] ?? null,
            'city'             => $validated['city'],
            'message'          => $validated['message'] ?? null,
            'status'           => 'new',
        ]);

        return redirect()
            ->route('frontend.services')
            ->with('enquiry_success', true);
    }
}
