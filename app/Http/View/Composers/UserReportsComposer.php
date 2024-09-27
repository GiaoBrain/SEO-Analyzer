<?php

namespace App\Http\View\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserReportsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $view->with('reportsCount', $user->reportsCount);
        }
    }
}