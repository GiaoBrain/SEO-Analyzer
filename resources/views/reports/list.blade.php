@extends('layouts.app')

@section('site_title', formatTitle(request()->input('project') ? [e(request()->input('project')), __('Reports'), config('settings.title')] : [__('Reports'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                @if(config('settings.ad_reports_top'))
                    <div class="d-print-none mb-1">{!! config('settings.ad_reports_top') !!}</div>
                @endif

                @if(request()->input('project'))
                    @include('shared.breadcrumbs', ['breadcrumbs' => [
                        ['url' => route('dashboard'), 'title' => __('Home')],
                        ['url' => route('reports'), 'title' => __('Reports')],
                        ['title' => __('Project')],
                    ]])
                @else
                    @include('shared.breadcrumbs', ['breadcrumbs' => [
                        ['url' => route('dashboard'), 'title' => __('Home')],
                        ['title' => __('Reports')],
                    ]])
                @endif

                <div class="d-flex align-items-end">
                    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ request()->input('project') ? request()->input('project') : __('Reports') }}</h1>

                    <div class="d-flex align-items-center flex-grow-0 d-print-none">
                        <div class="form-row flex-nowrap">
                            <div class="col">
                                @if(request()->input('project'))
                                    @include('projects.partials.menu')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @include('reports.new')

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header align-items-center">
                        <div class="row">
                            <div class="col"><div class="font-weight-medium py-1">{{ __('Reports') }}</div></div>
                            <div class="col-auto">
                                <div class="form-row">
                                    <div class="col">
                                        <form method="GET" action="{{ route('reports') }}" class="d-md-flex">
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
                                                                    @foreach(['url' => __('URL')] as $key => $value)
                                                                        <option value="{{ $key }}" @if(request()->input('search_by') == $key || !request()->input('search_by') && $key == 'name') selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-project" class="small">{{ __('Project') }}</label>
                                                                <select name="project" id="i-project" class="custom-select custom-select-sm">
                                                                    <option value="">{{ __('All') }}</option>
                                                                    @foreach($projects as $project)
                                                                        <option value="{{ $project->project }}" @if(request()->input('project') == $project->project && request()->input('project') !== null) selected @endif>{{ $project->project }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-result" class="small">{{ __('Result') }}</label>
                                                                <select name="result" id="i-result" class="custom-select custom-select-sm">
                                                                    <option value="">{{ __('All') }}</option>
                                                                    @foreach(['good' => __('Good'), 'decent' => __('Decent'), 'bad' => __('Bad')] as $key => $value)
                                                                        <option value="{{ $key }}" @if(request()->input('result') == $key && request()->input('result') !== null) selected @endif>{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group px-4">
                                                                <label for="i-sort-by" class="small">{{ __('Sort by') }}</label>
                                                                <select name="sort_by" id="i-sort-by" class="custom-select custom-select-sm">
                                                                    @foreach(['id' => __('Date created'), 'generated_at' => __('Date generated'), 'url' => __('URL'), 'result' => __('Result')] as $key => $value)
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

                        @if(count($reports) == 0)
                            {{ __('No results found.') }}
                        @else
                            <div class="list-group list-group-flush my-n3">
                                <div class="list-group-item px-0 text-muted">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-8 col-lg-5 d-block text-truncate">
                                                    {{ __('URL') }}
                                                </div>

                                                <div class="col-md-4 col-lg-5 d-none d-md-block text-truncate">
                                                    {{ __('Result') }}
                                                </div>

                                                <div class="col-lg-2 d-none d-lg-block text-truncate">
                                                    {{ __('Generated at') }}
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

                                @foreach($reports as $report)
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col text-truncate">
                                                <div class="row">
                                                    <div class="col-12 col-md-8 col-lg-5 d-flex">
                                                        <div class="d-flex align-items-center text-truncate">
                                                            <img src="https://icons.duckduckgo.com/ip3/{{ parse_url($report->fullUrl, PHP_URL_HOST) }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                            <div class="text-truncate" data-enable="tooltip" title="{{ $report->url }}"><a href="{{ route('reports.show', $report->id) }}" dir="ltr">{{ $report->url }}</a></div>

                                                            @if($report->result > 79)
                                                                <div class="d-md-none badge badge-success {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ __('Good') }}</div>
                                                            @elseif($report->result > 49)
                                                                <div class="d-md-none badge badge-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ __('Decent') }}</div>
                                                            @else
                                                                <div class="d-md-none badge badge-danger {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ __('Bad') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="d-none d-md-flex col-12 col-md-4 col-lg-5">
                                                        <div class="row no-gutters w-100 align-items-center">
                                                            <div class="col-6 d-none d-lg-flex">
                                                                <div class="progress height-1.25 w-100">
                                                                    <div class="progress-bar rounded {{ ($report->result > 79 ? 'bg-success' : ($report->result > 49 ? 'bg-warning' : 'bg-danger')) }}" role="progressbar" style="width: {{ number_format($report->result) }}%" aria-valuenow="{{ number_format($report->result) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 d-none d-lg-flex small text-center px-2">
                                                                <span class="font-weight-bold">{{ number_format($report->result) }}</span><span class="text-muted">/100</span>
                                                            </div>
                                                            <div class="col-12 col-lg-3 d-none d-md-flex align-items-center">
                                                                @include('reports.partials.badge')
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-none d-lg-flex col-lg-2">
                                                        <div class="text-truncate" data-enable="tooltip" title="{{ $report->generated_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $report->generated_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex">
                                                <div class="form-row">
                                                    <div class="col">
                                                        @include('reports.partials.menu')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-3 align-items-center">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $reports->firstItem(), 'to' => $reports->lastItem(), 'total' => $reports->total()]) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            {{ $reports->onEachSide(1)->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(config('settings.ad_reports_bottom'))
            <div class="d-print-none mt-3">{!! config('settings.ad_reports_bottom') !!}</div>
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
                <a href="{{ route('reports.export', Request::query()) }}" target="_self" class="btn btn-primary" id="exportButton">{{ __('Export') }}</a>
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