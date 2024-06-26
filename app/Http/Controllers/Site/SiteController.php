<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index(){
        $plans = Plan::with('details')->get();

        return view('site.pages.home.index', compact('plans'));
    }
}
