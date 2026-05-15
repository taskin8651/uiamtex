<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class UpgradeExtinguisherController extends Controller
{
    public function index()
    {
        return view('frontend.upgrade_your_extinguisher');
    }
}
