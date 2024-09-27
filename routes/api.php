<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:api', 'throttle:240')->group(function () {
    Route::apiResource('projects', 'API\ProjectController', ['parameters' => [
        'projects' => 'project'
    ], 'only' => ['index', 'destroy'], 'as' => 'api']);

    Route::apiResource('reports', 'API\ReportController', ['parameters' => [
        'reports' => 'id'
    ], 'as' => 'api']);

    Route::apiResource('account', 'API\AccountController', ['only' => [
        'index'
    ], 'as' => 'api']);

    Route::fallback(function () {
        return response()->json(['message' => __('Resource not found.'), 'status' => 404], 404);
    });
});