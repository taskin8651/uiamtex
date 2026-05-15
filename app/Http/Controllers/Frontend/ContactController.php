<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        // SiteSetting is already shared globally from Service Provider
        return view('frontend.contact');
    }
}
