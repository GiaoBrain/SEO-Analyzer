@extends('layouts.app')

@section('site_title', formatTitle([__('Projects'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                @if(config('settings.ad_projects_top'))
                    <div class="d-print-none mb-1">{!! config('settings.ad_projects_top') !!}</div>
                @endif
                
                @include('shared.breadcrumbs', ['breadcrumbs' => [
                    ['url' => route('dashboard'), 'title' => __('Home')],
                    ['title' => __('Projects')],
                ]])

                <div class="d-flex align-items-end">
                    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ __('Projects') }}</h1>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header align-items-center">
                        <div class="row">
                            <div class="col"><div class="font-weight-medium py-1">{{ __('Projects') }}</div></div>
                            <div class="col-auto">
                                <div class="form-row">
                                    <div class="col">
                                        <form method="GET" action="{{ route('projects') }}" class="d-md-flex">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-primary d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                                                    <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64 p-0" id="search-filters">
                                                        <div class="dropdown-header py-3">
                                                            <div class="row">
                                                                <div class="col"><div class="font-weight-medium m-0 text-body">{{ __('Filters') }}</div></div>
                                                                <div class="col-auto">
                                                                    @if(request()->input('per_page'))
                                                                        <a href="{{ route('reports') }}" class="text-secondary">{{ __('Reset') }}</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown-divider my-0"></div>

                                                        <div class="max-height-96 overflow-auto pt-3">
                                                            <div class="form-group px-4">
                                                                <label for="i-search-by" class="small">{{ __('Search by') }}</label>
                                                                <select name="search_by" id="i-search-by" class="custom-select custom-select-sm">
                                                                    @foreach(['project' => __('Name')] as $key => $value)
                                                                        <option value="{{ $key }}" @if(request()->input('search_by') == $key || !request()->input('search_by') && $key == 'name') selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-sort-by" class="small">{{ __('Sort by') }}</label>
                                                                <select name="sort_by" id="i-sort-by" class="custom-select custom-select-sm">
                                                                    @foreach(['created_at' => __('Date created'), 'project' => __('Name')] as $key => $value)
                                                                        <option value="{{ $key }}" @if(request()->input('sort_by') == $key) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-sort" class="small">{{ __('Sort') }}</label>
                                                                <select name="sort" id="i-sort" class="custom-select custom-select-sm">
                                                                    @foreach(['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                                                        <option value="{{ $key }}" @if(request()->input('sort') == $key) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-per-page" class="small">{{ __('Results per page') }}</label>
                                                                <select name="per_page" id="i-per-page" class="custom-select custom-select-sm">
                                                                    @foreach([10, 25, 50, 100] as $value)
                                                                        <option value="{{ $value }}" @if(request()->input('per_page') == $value || request()->input('per_page') == null && $value == config('settings.paginate')) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown-divider my-0"></div>

                                                        <div class="px-4 py-3">
                                                            <button type="submit" class="btn btn-primary btn-sm btn-block">{{ __('Search') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-toggle="modal" data-target="#export-modal" data-enable="tooltip" title="{{ __('Export') }}">@include('icons.export', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('shared.message')

                        @if(count($projects) == 0)
                            {{ __('No results found.') }}
                        @else
                            <div class="list-group list-group-flush my-n3">
                                <div class="list-group-item px-0 text-muted">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-8 col-lg-6 d-block text-truncate">
                                                    {{ __('Name') }}
                                                </div>

                                                <div class="col-md-4 col-lg-2 d-none d-md-block text-truncate">
                                                    {{ __('Result') }}
                                                </div>

                                                <div class="col-lg-2 d-none d-lg-block text-truncate">
                                                    {{ __('Reports') }}
                                                </div>

                                                <div class="col-lg-2 d-none d-lg-block text-truncate">
                                                    {{ __('Created at') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="invisible btn d-flex align-items-center btn-sm text-primary">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach($projects as $project)
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col text-truncate">
                                                <div class="row">
                                                    <div class="col-12 col-md-8 col-lg-6 d-flex">
                                                        <div class="d-flex align-items-center text-truncate">
                                                            <img src="https://icons.duckduckgo.com/ip3/{{ $project->project }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                            <a href="{{ route('reports', ['project' => $project->project]) }}" dir="ltr" class="text-truncate">{{ $project->project }}</a>
                                                        </div>
                                                    </div>

                                                    <div class="d-none d-md-flex align-items-center col-md-4 col-lg-2 text-truncate">
                                                        <a href="{{ route('reports', ['project' => $project->project]) }}" class="badge {{ (($project->result / $project->reports) > 79 ? 'badge-success' : (($project->result / $project->reports) > 49 ? 'badge-warning' : 'badge-danger')) }} text-truncate">{{ (($project->result / $project->reports) > 79 ? __('Good') : (($project->result / $project->reports) > 49 ? __('Decent') : __('Bad'))) }}</a>
                                                    </div>

                                                    <div class="col-lg-2 d-none d-lg-block text-truncate">
                                                        <a href="{{ route('reports', ['project' => $project->project]) }}" class="text-dark text-truncate">{{ number_format($project->reports, 0, __('.'), __(',')) }}</a>
                                                    </div>

                                                    <div class="d-none d-lg-flex col-lg-2">
                                                        <div class="text-truncate" data-enable="tooltip" title="{{ $project->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $project->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex">
                                                <div class="form-row">
                                                    <div class="col">
                                                        @include('projects.partials.menu')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-3 align-items-center">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $projects->firstItem(), 'to' => $projects->lastItem(), 'total' => $projects->total()]) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            {{ $projects->onEachSide(1)->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        @if(config('settings.ad_projects_bottom'))
            <div class="d-print-none mt-3">{!! config('settings.ad_projects_bottom') !!}</div>
        @endif
    </div>
</div>

<div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="export-modal-label">{{ __('Export') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-4 height-4'])</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to export this table?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <a href="{{ route('projects.export', Request::query()) }}" target="_self" class="btn btn-primary" id="exportButton">{{ __('Export') }}</a>
            </div>
        </div>
    </div>
</div>
<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        jQuery('#exportButton').on('click', function () {
            jQuery('#export-modal').modal('hide');
        });
    });
</script>

@endsection
@include('shared.sidebars.user')