<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PricingController extends Controller
{
    /**
     * Show the Pricing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $plans = Plan::where('visibility', 1)->orderBy('position')->orderBy('id')->get();

        return view('pricing.index', ['plans' => $plans]);
    }
}
