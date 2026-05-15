<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Client;
use App\Models\Download;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class CertificatesClientsController extends Controller
{
    public function index(Request $request)
    {
        $activeYes = ['yes', 'YES', 'Yes', 1, '1', true, 'true'];

        $certifications = Certification::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $clients = Client::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $downloads = Download::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('id', 'desc')
            ->get();

        // ✅ Testimonials (active only)
        $testimonials = Testimonial::query()
            ->where(function ($q) use ($activeYes) {
                $q->whereIn('is_active', $activeYes)
                  ->orWhere('is_active', 'like', 'yes%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.certificates_clientc', compact(
            'certifications',
            'clients',
            'downloads',
            'testimonials'
        ));
    }
}
