<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['project']) ? $request->input('search_by') : 'project';
        $sortBy = in_array($request->input('sort_by'), ['project', 'created_at']) ? $request->input('sort_by') : 'created_at';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        return ProjectResource::collection(Report::select([DB::raw("`project`, SUBSTRING_INDEX(GROUP_CONCAT(`created_at` ORDER BY `created_at` ASC), ',', 1) AS `created_at`, COUNT(*) as `reports`, SUM(`result`) as `result`")])->where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search, $searchBy) {
                return $query->searchProject($search);
            })
            ->groupBy('project')
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]))
            ->additional(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $project)
    {
        $reports = Report::destroy(Report::where([['user_id', '=', $request->user()->id], ['project', '=', $project]])->get(['id'])->toArray());

        if ($reports) {
            Report::destroy($reports);

            return response()->json([
                'id' => $project,
                'object' => 'report',
                'deleted' => true,
                'status' => 200
            ], 200);
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}
