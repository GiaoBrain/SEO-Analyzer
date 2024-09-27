<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // If the user previously selected a plan
        if (!empty($request->session()->get('plan_redirect'))) {
            return redirect()->route('checkout.index', ['id' => $request->session()->get('plan_redirect')['id'], 'interval' => $request->session()->get('plan_redirect')['interval']]);
        }

        $latestReports = Report::where('user_id', $request->user()->id)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $underperformingReports = Report::where('user_id', $request->user()->id)
            ->where('result', '<>', 1)
            ->orderBy('result', 'asc')
            ->limit(5)
            ->get();

        $latestProjects = Report::select([DB::raw("`project`, SUBSTRING_INDEX(GROUP_CONCAT(`created_at` ORDER BY `created_at` ASC), ',', 1) AS `created_at`, COUNT(*) as `reports`, SUM(`result`) as `result`")])->where('user_id', $request->user()->id)
            ->groupBy('project')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $goodReportsCount = Report::where('user_id', $request->user()->id)
            ->ofResult('good')
            ->count();

        $decentReportsCount = Report::where('user_id', $request->user()->id)
            ->ofResult('decent')
            ->count();

        $badReportsCount = Report::where('user_id', $request->user()->id)
            ->ofResult('bad')
            ->count();

        return view('dashboard.index', ['latestReports' => $latestReports, 'latestProjects' => $latestProjects, 'underperformingReports' => $underperformingReports, 'goodReportsCount' => $goodReportsCount, 'decentReportsCount' => $decentReportsCount, 'badReportsCount' => $badReportsCount]);
    }
}
