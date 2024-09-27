@section('site_title', formatTitle([__('Cron jobs'), __('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h1 class="h2 mb-3 d-inline-block">{{ __('Cron jobs') }}</h1>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Cron jobs') }}</div></div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <div class="form-group">
            <label for="i-cronjob-cache">{!! __(':name command', ['name' => '<span class="badge badge-primary">cache</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text">0 6 * * 0</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_cache" id="i-cronjob-cache" class="form-control" value="wget {{ route('cronjobs.cache', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-cronjob-cache">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="i-cronjob-clean">{!! __(':name command', ['name' => '<span class="badge badge-danger">clean</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text">1 0 * * *</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_clean" id="i-cronjob-clean" class="form-control" value="wget {{ route('cronjobs.clean', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-cronjob-clean">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-action="{{ route('admin.settings', 'cronjobs') }}" data-button="btn btn-danger" data-title="{{ __('Regenerate') }}" data-text="{{ __('If you regenerate the cron job key, you will need to update the cron job tasks with the new commands.') }}">{{ __('Regenerate') }}</button>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('History') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.settings', 'cronjobs') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64 p-0" id="search-filters">
                                <div class="dropdown-header py-3">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-body">{{ __('Filters') }}</div></div>
                                        <div class="col-auto"><a href="{{ route('admin.settings', 'cronjobs') }}" class="text-secondary">{{ __('Reset') }}</a></div>
                                    </div>
                                </div>

                                <div class="dropdown-divider my-0"></div>

                                <div class="max-height-96 overflow-auto pt-3">
                                    <div class="form-group px-4">
                                        <label for="i-search-by" class="small">{{ __('Search by') }}</label>
                                        <select name="search_by" id="i-search-by" class="custom-select custom-select-sm">
                                            @foreach(['name' => __('Name')] as $key => $value)
                                                <option value="{{ $key }}" @if(request()->input('search_by') == $key || !request()->input('search_by') && $key == 'name') selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group px-4">
                                        <label for="i-sort-by" class="small">{{ __('Sort by') }}</label>
                                        <select name="sort_by" id="i-sort-by" class="custom-select custom-select-sm">
                                            @foreach(['id' => __('Date created'), 'name' => __('Name')] as $key => $value)
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
        </div>
    </div>
    <div class="card-body">
        @if(count($cronjobs) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm">{{ __('Name') }}</div>
                        <div class="col-12 col-sm-auto">{{ __('Date') }}</div>
                    </div>
                </div>

                @foreach($cronjobs as $cronjob)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm d-flex text-truncate">
                                @if($cronjob->name == 'cache')
                                    <div class="badge badge-primary text-truncate">
                                        {{ $cronjob->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-auto text-truncate">
                                {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }} {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format('H:i:s') }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $cronjobs->firstItem(), 'to' => $cronjobs->lastItem(), 'total' => $cronjobs->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $cronjobs->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>