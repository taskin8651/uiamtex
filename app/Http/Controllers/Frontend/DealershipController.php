<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DealershipController extends Controller
{
    public function index()
    {
        return view('frontend.dealership');
    }
}
