<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // If the user is logged-in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // If there's a custom site index
        if (config('settings.index')) {
            return redirect()->to(config('settings.index'), 301)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

        // If there's a payment processor enabled
        if (paymentProcessors()) {
            $plans = Plan::where('visibility', 1)->orderBy('position')->orderBy('id')->get();
        } else {
            $plans = null;
        }

        return view('home.index', ['plans' => $plans]);
    }
}
