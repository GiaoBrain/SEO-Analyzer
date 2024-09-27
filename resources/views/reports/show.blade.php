@section('site_title', formatTitle([$report->host, __('Report'), config('settings.title')]))

@section('head_content')

@endsection

@if(config('settings.ad_report_top'))
    <div class="d-print-none mb-1">{!! config('settings.ad_report_top') !!}</div>
@endif

<div class="d-print-none">
    @if(Auth::check() && Auth::user()->id == $report->user_id)
        @include('shared.breadcrumbs', ['breadcrumbs' => [
            ['url' => route('dashboard'), 'title' => __('Home')],
            ['url' => route('reports', ['project' => $report->project]), 'title' => __('Reports')],
            ['title' => __('Report')]
        ]])
    @else
        @include('shared.breadcrumbs', ['breadcrumbs' => [
            ['url' => route('dashboard'), 'title' => __('Home')],
            ['title' => __('Report')]
        ]])
    @endif
</div>

<div class="d-none d-print-block border-bottom pb-3 mb-3">
    <div class="row">
        <div class="col">
            <div class="row no-gutters">
                <div class="col-auto d-flex align-items-center">
                    @if(isset($report->user->brand->logo) && $report->user->brand->logo)
                        <img src="{{ $report->user->brand->logo }}" class="height-10 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                    @endif
                </div>
                <div class="col d-flex align-items-center">
                    <div class="">
                        @if(isset($report->user->brand->name) && $report->user->brand->name)
                            <div class="font-weight-bold">{{ $report->user->brand->name }}</div>
                        @endif

                        @if(isset($report->user->brand->url) && $report->user->brand->url)
                            <div><a href="{{ $report->user->brand->url }}" rel="nofollow" target="_blank" class="text-decoration-none">{{ $report->user->brand->url }}</a></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-auto d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'text-left' : 'text-right') }}">
            <div>
                @if(isset($report->user->brand->email) && $report->user->brand->email)
                    <div><a href="mailto:{{ $report->user->brand->email }}" class="text-secondary text-decoration-none">{{ $report->user->brand->email }}</a></div>
                @endif

                @if(isset($report->user->brand->phone) && $report->user->brand->phone)
                    <div><a href="tel:{{ $report->user->brand->phone }}" class="text-secondary text-decoration-none">{{ $report->user->brand->phone }}</a></div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex align-items-end mb-3">
    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ $report->url }}</h1>

    <div class="d-flex align-items-center flex-grow-0 d-print-none">
        <div class="form-row flex-nowrap">
            <div class="col">
                <a href="#" class="btn text-secondary d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</a>

                @include('reports.partials.menu')
            </div>

            @if(Auth::check() && Auth::user()->id == $report->user_id)
                <div class="col">
                    <form action="{{ route('reports.edit', ['id' => $report->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input name="results" type="hidden" value="true">

                        <button type="submit" class="btn text-secondary d-flex align-items-center position-relative" data-enable="tooltip" title="{{ __('Refresh') }}" data-button-loader>
                            <div class="position-absolute top-0 right-0 bottom-0 left-0 d-flex align-items-center justify-content-center">
                                <span class="d-none spinner-border spinner-border-sm width-4 height-4" role="status"></span>
                            </div>
                            @include('icons.refresh', ['class' => 'fill-current width-4 height-4 spinner-text'])&#8203;
                        </button>
                    </form>
                </div>
            @endif

            <div class="col">
                <a class="btn text-secondary d-flex align-items-center" onclick="window.print();" data-enable="tooltip" title="{{ __('Print') }}">@include('icons.print', ['class' => 'fill-current width-4 height 4'])&#8203;</a>
            </div>
        </div>
    </div>
</div>

<div class="d-print-none d-flex position-relative mb-3 position-xl-sticky sticky-top @auth top-lg-0 @else top-0 top-xl-18 @endauth z-1000">
    <nav class="navbar navbar-expand-xl navbar-light w-100 p-0 bg-base-0 rounded shadow-sm">
        <div class="d-flex align-items-center d-xl-none px-3 py-3 font-weight-medium text-muted">
            {{ __('Menu') }}
        </div>
        <button class="navbar-toggler border-0 py-2 collapsed {{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }}" type="button" data-toggle="collapse" data-target="#reports-navbar" aria-controls="reports-navbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon my-1"></span>
        </button>

        <div class="collapse navbar-collapse border-top border-top-xl-0 @auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth" id="reports-navbar">
            <ul class="navbar-nav flex-wrap justify-content-around w-100">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3" href="#overview">
                        <span class="d-flex align-items-center">@include('icons.list-alt', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])</span>
                        <span>{{ __('Overview') }}</span>
                    </a>
                </li>

                <li class="{{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }} "></li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3" href="#seo">
                        <span class="d-flex align-items-center">@include('icons.search', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])</span>
                        <span>{{ __('SEO') }}</span>
                        @if($report->highIssuesSeoCount)
                            <span class="badge badge-danger {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->highIssuesSeoCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->mediumIssuesSeoCount)
                            <span class="badge badge-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->mediumIssuesSeoCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->lowIssuesSeoCount)
                            <span class="badge badge-secondary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->lowIssuesSeoCount, 0, __('.'), __(',')) }}</span>
                        @endif
                    </a>
                </li>

                <li class="{{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }} "></li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3" href="#performance">
                        <span class="d-flex align-items-center">@include('icons.speed', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])</span>
                        <span>{{ __('Performance') }}</span>
                        @if($report->highIssuesPerformanceCount)
                            <span class="badge badge-danger {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->highIssuesPerformanceCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->mediumIssuesPerformanceCount)
                            <span class="badge badge-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->mediumIssuesPerformanceCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->lowIssuesPerformanceCount)
                            <span class="badge badge-secondary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->lowIssuesPerformanceCount, 0, __('.'), __(',')) }}</span>
                        @endif
                    </a>
                </li>

                <li class="{{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }} "></li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3" href="#security">
                        <span class="d-flex align-items-center">@include('icons.health-and-guard', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])</span>
                        <span>{{ __('Security') }}</span>
                        @if($report->highIssuesSecurityCount)
                            <span class="badge badge-danger {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->highIssuesSecurityCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->mediumIssuesSecurityCount)
                            <span class="badge badge-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->mediumIssuesSecurityCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->lowIssuesSecurityCount)
                            <span class="badge badge-secondary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->lowIssuesSecurityCount, 0, __('.'), __(',')) }}</span>
                        @endif
                    </a>
                </li>

                <li class="{{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }} "></li>

                <li class="nav-item {{ Route::currentRouteName() == 'stats.overview' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3" href="#miscellaneous">
                        <span class="d-flex align-items-center">@include('icons.category', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])</span>
                        <span>{{ __('Miscellaneous') }}</span>
                        @if($report->highIssuesMiscellaneousCount)
                            <span class="badge badge-danger {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->highIssuesMiscellaneousCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->mediumIssuesMiscellaneousCount)
                            <span class="badge badge-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->mediumIssuesMiscellaneousCount, 0, __('.'), __(',')) }}</span>
                        @endif
                        @if($report->lowIssuesMiscellaneousCount)
                            <span class="badge badge-secondary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ number_format($report->lowIssuesMiscellaneousCount, 0, __('.'), __(',')) }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="@auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth" id="overview">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col"><div class="font-weight-medium py-1">{{ __('Overview') }}</div></div>
                <div class="col-auto d-flex align-items-center">
                    <div class="d-none d-print-flex">
                        {{ __('Report generated on :date at :time (UTC :offset).', ['date' => \Carbon\Carbon::now()->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => \Carbon\Carbon::now()->tz(Auth::user()->timezone ?? config('app.timezone'))->format('H:i:s'), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                    </div>
                    <div class="d-print-none text-muted" data-enable="tooltip" title="{{ $report->generated_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $report->generated_at->tz(Auth::user()->timezone ?? config('app.timezone'))->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->first('results'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('results') }}
                    <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-12 p-0" data-dismiss="alert" aria-label="{{ __('Close') }}">
                        <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-4 height-4'])</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-lg">
                    <div class="row">
                        <div class="col-12 col-lg-auto">
                            <div class="mx-auto mx-lg-0 position-relative d-flex align-items-center justify-content-center width-40 height-40 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 160 160" class="{{ ($report->result > 79 ? 'stroke-success' : ($report->result > 49 ? 'stroke-warning' : 'stroke-danger')) }}" width="144" height="144">
                                    <circle cx="80" cy="80" r="75" stroke="#ddd" stroke-width="5" fill="transparent"/>

                                    <path d="M80,5A75,75,0,1,1,5,80,75,75,0,0,1,80,5" stroke-linecap="round" stroke-width="10" fill="transparent" stroke-dasharray="{{ number_format(($report->result / 100) * (2*3.14*75)) }},{{ number_format((2*3.14*75)) }}"/>
                                </svg>
                                <div class="position-absolute">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="font-weight-bold h1 mb-0">
                                            {{ number_format($report->result) }}
                                        </div>

                                        <div class="text-muted border-top pt-1">
                                            100
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg text-center {{ (__('lang_dir') == 'rtl' ? 'text-lg-right' : 'text-lg-left') }}">
                            <div class="my-2 h5">{{ $report['results']['title']['value'] }}</div>
                            <div class="my-2 text-break text-muted">{{ $report['results']['meta_description']['value'] }}</div>
                            <div class="my-2 text-break"><a href="{{ $report['results']['seo_friendly_url']['value'] }}" rel="nofollow" target="_blank">{{ $report['results']['seo_friendly_url']['value'] }}</a></div>
                        </div>
                    </div>
                </div>

                @if(config('settings.ti'))
                    <div class="col-12 col-lg-auto d-flex justify-content-center d-lg-block">
                        <img src="//image.thum.io/get{{ config('settings.ti_key') ? '/auth/' . config('settings.ti_key') : '' }}/width/504/crop/760/{{ $report->fullUrl }}" width="252px" class="rounded mt-3 mt-lg-0">
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="my-2">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <div class="d-flex text-truncate align-items-center">
                                @include('icons.triangle', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->highIssuesCount > 0 ? 'text-danger ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

                                <div class="text-truncate">{{ __(($report->highIssuesCount == 1 ? ':value high issue' : ':value high issues'), ['value' => number_format($report->highIssuesCount, 0, __('.'), __(','))]) }}</div>
                            </div>

                            <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                <div class="width-12">
                                    {{ number_format((($report->highIssuesCount / $report->totalTestsCount) * 100), 1, __('.'), __(',')) }}%
                                </div>
                            </div>
                        </div>

                        <div class="progress height-1.25 w-100">
                            <div class="progress-bar bg-danger rounded" role="progressbar" style="width: {{ number_format((($report->highIssuesCount / $report->totalTestsCount) * 100)) }}%" aria-valuenow="{{ number_format((($report->highIssuesCount / $report->totalTestsCount) * 100)) }}" aria-valuemin="0" aria-valuemax="{{ $report->totalTestsCount }}"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="my-2">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <div class="d-flex text-truncate align-items-center">
                                @include('icons.square', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->mediumIssuesCount > 0 ? 'text-warning ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

                                <div class="text-truncate">{{ __(($report->mediumIssuesCount == 1 ? ':value medium issue' : ':value medium issues'), ['value' => number_format($report->mediumIssuesCount, 0, __('.'), __(','))]) }}</div>
                            </div>

                            <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                <div class="width-12">
                                    {{ number_format((($report->mediumIssuesCount / $report->totalTestsCount) * 100), 1, __('.'), __(',')) }}%
                                </div>
                            </div>
                        </div>

                        <div class="progress height-1.25 w-100">
                            <div class="progress-bar bg-warning rounded" role="progressbar" style="width: {{ number_format((($report->mediumIssuesCount / $report->totalTestsCount) * 100)) }}%" aria-valuenow="{{ number_format((($report->mediumIssuesCount / $report->totalTestsCount) * 100)) }}" aria-valuemin="0" aria-valuemax="{{ $report->totalTestsCount }}"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="my-2">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <div class="d-flex text-truncate align-items-center">
                                @include('icons.circle', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->lowIssuesCount > 0 ? 'text-secondary ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

                                <div class="text-truncate">{{ __(($report->lowIssuesCount == 1 ? ':value low issue' : ':value low issues'), ['value' => number_format($report->lowIssuesCount, 0, __('.'), __(','))]) }}</div>
                            </div>

                            <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                <div class="width-12">
                                    {{ number_format((($report->lowIssuesCount / $report->totalTestsCount) * 100), 1, __('.'), __(',')) }}%
                                </div>
                            </div>
                        </div>

                        <div class="progress height-1.25 w-100">
                            <div class="progress-bar bg-secondary rounded" role="progressbar" style="width: {{ number_format((($report->lowIssuesCount / $report->totalTestsCount) * 100)) }}%" aria-valuenow="{{ number_format((($report->lowIssuesCount / $report->totalTestsCount) * 100)) }}" aria-valuemin="0" aria-valuemax="{{ $report->totalTestsCount }}"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="my-2">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <div class="d-flex text-truncate align-items-center">
                                <div class="text-truncate">{{ __(($report->nonIssuesCount == 1 ? ':value test passed' : ':value tests passed'), ['value' => $report->nonIssuesCount]) }}</div>
                            </div>

                            <div class="d-flex align-items-baseline {{ (__('lang_dir') == 'rtl' ? 'mr-3 text-left' : 'ml-3 text-right') }}">
                                <div class="width-12">
                                    {{ number_format((($report->nonIssuesCount / $report->totalTestsCount) * 100), 1, __('.'), __(',')) }}%
                                </div>
                            </div>
                        </div>

                        <div class="progress height-1.25 w-100">
                            <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{ number_format((($report->nonIssuesCount / $report->totalTestsCount) * 100)) }}%" aria-valuenow="{{ number_format((($report->nonIssuesCount / $report->totalTestsCount) * 100)) }}" aria-valuemin="0" aria-valuemax="{{ $report->totalTestsCount }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 my-2 d-flex align-items-center">
                    <div class="d-flex position-relative text-secondary width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                        <div class="position-absolute bg-secondary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-lg"></div>
                        @include('icons.timer', ['class' => 'fill-current width-4 height-4'])
                    </div>
                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Load time') }}">
                        {{ __(':value seconds', ['value' => number_format($report['results']['load_time']['value'], 2, __('.'), __(','))]) }}
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 my-2 d-flex align-items-center">
                    <div class="d-flex position-relative text-secondary width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                        <div class="position-absolute bg-secondary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-lg"></div>
                        @include('icons.balance', ['class' => 'fill-current width-4 height-4'])
                    </div>
                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Page size') }}">
                        {{ formatBytes($report['results']['page_size']['value'], 2, __('.'), __(',')) }}
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 my-2 d-flex align-items-center">
                    <div class="d-flex position-relative text-secondary width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                        <div class="position-absolute bg-secondary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-lg"></div>
                        @include('icons.device-hub', ['class' => 'fill-current width-4 height-4'])
                    </div>
                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('HTTP requests') }}">
                        {{ __((array_sum(array_map('count', $report['results']['http_requests']['value'])) == 1 ? ':value resource' : ':value resources'), ['value' => number_format(array_sum(array_map('count', $report['results']['http_requests']['value'])), 0, __('.'), __(','))]) }}
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 my-2 d-flex align-items-center">
                    <div class="d-flex position-relative text-secondary width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                        <div class="position-absolute bg-secondary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-lg"></div>
                        @include('icons.lock', ['class' => 'fill-current width-4 height-4'])
                    </div>
                    <div class="{{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('HTTPS encryption') }}">
                        @if($report['results']['https_encryption']['passed'])
                            {{ __('Secure') }}
                        @else
                            {{ __('Insecure') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="@auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth mt-3" id="seo">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header align-items-center border-bottom-0">
            <div class="row">
                <div class="col"><div class="font-weight-medium py-1">{{ __('SEO') }}</div></div>
            </div>
        </div>

        @foreach($report->categories['seo'] as $category)
            @include('reports.partials.' . str_replace('_', '-', $category), ['name' => $category])
        @endforeach
    </div>
</div>

<div class="@auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth mt-3" id="performance">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header align-items-center border-bottom-0">
            <div class="row">
                <div class="col"><div class="font-weight-medium py-1">{{ __('Performance') }}</div></div>
            </div>
        </div>

        @foreach($report->categories['performance'] as $category)
            @include('reports.partials.' . str_replace('_', '-', $category), ['name' => $category])
        @endforeach
    </div>
</div>

<div class="@auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth mt-3" id="security">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header align-items-center border-bottom-0">
            <div class="row">
                <div class="col"><div class="font-weight-medium py-1">{{ __('Security') }}</div></div>
            </div>
        </div>

        @foreach($report->categories['security'] as $category)
            @include('reports.partials.' . str_replace('_', '-', $category), ['name' => $category])
        @endforeach
    </div>
</div>

<div class="@auth scroll-margin-top-22 scroll-margin-top-lg-4 scroll-margin-top-xl-18 @else scroll-margin-top-22 scroll-margin-top-xl-36 @endauth mt-3" id="miscellaneous">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header align-items-center border-bottom-0">
            <div class="row">
                <div class="col"><div class="font-weight-medium py-1">{{ __('Miscellaneous') }}</div></div>
            </div>
        </div>

        @foreach($report->categories['miscellaneous'] as $category)
            @include('reports.partials.' . str_replace('_', '-', $category), ['name' => $category])
        @endforeach
    </div>
</div>

@if(config('settings.ad_report_bottom'))
    <div class="d-print-none mt-3">{!! config('settings.ad_report_bottom') !!}</div>
@endif