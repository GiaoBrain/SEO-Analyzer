<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv as CSV;

class ProjectController extends Controller
{
    /**
     * List the Projects.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['project']) ? $request->input('search_by') : 'project';
        $sortBy = in_array($request->input('sort_by'), ['created_at', 'project']) ? $request->input('sort_by') : 'created_at';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $projects = Report::select([DB::raw("`project`, SUBSTRING_INDEX(GROUP_CONCAT(`created_at` ORDER BY `created_at` ASC), ',', 1) AS `created_at`, COUNT(*) as `reports`, SUM(`result`) as `result`")])->where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search, $searchBy) {
                return $query->searchProject($search);
            })
            ->groupBy('project')
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('projects.list', ['projects' => $projects]);
    }

    /**
     * Delete the Project.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $reports = Report::where([['user_id', '=', $request->user()->id], ['project', '=', $id]])->get(['id'])->toArray();

        Report::destroy($reports);

        return redirect()->route('projects')->with('success', __(':name has been deleted.', ['name' => $id]));
    }

    /**
     * Export the Projects.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws CSV\CannotInsertRecord
     */
    public function export(Request $request)
    {
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['project']) ? $request->input('search_by') : 'project';
        $sortBy = in_array($request->input('project'), ['project']) ? $request->input('project') : 'project';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'asc';

        $projects = Report::select([DB::raw("`project`, COUNT(*) as `reports`, SUM(`result`) as `result`")])->where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search, $searchBy) {
                return $query->searchProject($search);
            })
            ->groupBy('project')
            ->orderBy($sortBy, $sort)
            ->get();

        $content = CSV\Writer::createFromFileObject(new \SplTempFileObject);

        // Generate the header
        $content->insertOne([__('Type'), __('Projects')]);
        $content->insertOne([__('Date'), Carbon::now()->tz($request->user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) . ' ' . Carbon::now()->tz($request->user()->timezone ?? config('app.timezone'))->format('H:i:s') . ' (' . CarbonTimeZone::create($request->user()->timezone ?? config('app.timezone'))->toOffsetName() . ')']);
        $content->insertOne([__('URL'), $request->fullUrl()]);
        $content->insertOne([__(' ')]);

        // Generate the content
        $content->insertOne([__('Name'), __('Result'), __('Reports')]);
        foreach ($projects as $project) {
            $content->insertOne([$project->project, $project->result, $project->reports]);
        }

        return response((string) $content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="' . formatTitle([__('Projects'), config('settings.title')]) . '.csv"',
        ]);
    }
}
