@extends('layouts.app')

@section('site_title', formatTitle([__('Dashboard'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="bg-base-0">
        <div class="container py-5">
            @if(config('settings.ad_dashboard_top'))
                <div class="d-print-none mb-3">{!! config('settings.ad_dashboard_top') !!}</div>
            @endif

            <div class="d-flex">
                <div class="row no-gutters w-100">
                    <div class="d-flex col-12 col-md">
                        <div class="flex-shrink-1">
                            <a href="{{ route('account') }}" class="d-block"><img src="{{ gravatar(Auth::user()->email, 128) }}" class="rounded-circle width-16 height-16"></a>
                        </div>
                        <div class="flex-grow-1 d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-3' : 'ml-3') }}">
                            <div>
                                <h4 class="font-weight-medium mb-0">{{ Auth::user()->name }}</h4>

                                <div class="d-flex flex-wrap">
                                    @if(paymentProcessors())
                                        <div class="d-inline-block mt-2 {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                            <div class="d-flex">
                                                <div class="d-inline-flex align-items-center">
                                                    @include('icons.package', ['class' => 'text-muted fill-current width-4 height-4'])
                                                </div>

                                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                                    <a href="{{ route('account.plan') }}" class="text-dark text-decoration-none">{{ Auth::user()->plan->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-inline-block mt-2 {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                            <div class="d-flex">
                                                <div class="d-inline-flex align-items-center">
                                                    @include('icons.email', ['class' => 'text-muted fill-current width-4 height-4'])
                                                </div>

                                                <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                                    {{ Auth::user()->email }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(paymentProcessors())
                        @if(Auth::user()->planOnDefault())
                            <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                                <a href="{{ route('pricing') }}" class="btn btn-outline-primary btn-block d-flex justify-content-center align-items-center mt-3 mt-md-0 {{ (__('lang_dir') == 'rtl' ? 'ml-md-3' : 'mr-md-3') }}">@include('icons.unarchive', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('Upgrade') }}</a>
                            </div>
                        @else
                            <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                                <a href="{{ route('pricing') }}" class="btn btn-outline-primary btn-block d-flex justify-content-center align-items-center mt-3 mt-md-0 {{ (__('lang_dir') == 'rtl' ? 'ml-md-3' : 'mr-md-3') }}">@include('icons.package', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('Plans') }}</a>
                            </div>
                        @endif
                    @endif

                    <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center">
                        <a href="{{ route('reports') }}" class="btn btn-primary btn-block d-flex justify-content-center align-items-center mt-3 mt-md-0">@include('icons.add', ['class' => 'width-4 height-4 fill-current '.(__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')]){{ __('New report') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-base-1">
        <div class="container py-3 my-3">
            <div class="row">
                <div class="col-12 col-lg">
                    <h4 class="mb-0">{{ __('Overview') }}</h4>
                </div>
            </div>

            <div class="card border-0 rounded-top shadow-sm my-3 overflow-hidden mb-5">
                <div class="px-3">
                    <div class="row">
                        <!-- Title -->
                        <div class="col-12 col-lg-auto d-none d-lg-flex align-items-center border-bottom border-bottom-lg-0 {{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }}">
                            <div class="px-2 py-4 d-flex">
                                <div class="d-flex position-relative text-primary width-10 height-10 align-items-center justify-content-center flex-shrink-0">
                                    <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-xl"></div>
                                    @include('icons.list-alt', ['class' => 'fill-current width-5 height-5'])
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg">
                            <div class="row h-100">
                                <!-- Bad -->
                                <div class="col-12 col-lg border-bottom border-bottom-lg-0 text-truncate {{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }}">
                                    <div class="px-1 py-4">
                                        <div class="d-flex align-items-center pb-1">
                                            @include('icons.triangle', ['class' => 'fill-current width-4 height-4 flex-shrink-0 text-danger'])

                                            <div class="flex-grow-1 mx-2 d-flex text-truncate">
                                                <a href="{{ route('reports', ['project' => request()->input('project'), 'result' => 'bad', 'sort_by' => 'result', 'sort' => 'asc']) }}" class="text-secondary font-weight-medium d-flex align-items-center text-truncate">
                                                    <span class="d-inline-block text-truncate">{{ __(($badReportsCount == 1 ? ':value bad report' : ':value bad reports'), ['value' => number_format($badReportsCount, 0, __('.'), __(','))]) }}</span>

                                                    @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current flex-shrink-0 '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center text-muted mb-0 text-truncate flex-shrink-0">
                                                {{ number_format($badReportsCount ? (($badReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0, 1, __('.'), __(',')) }}%
                                            </div>
                                        </div>

                                        <div class="progress height-1.25 w-100 mt-2">
                                            <div class="progress-bar bg-danger rounded" role="progressbar" style="width: {{ number_format($badReportsCount ? (($badReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}%" aria-valuenow="{{ number_format($badReportsCount ? (($badReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}" aria-valuemin="0" aria-valuemax="{{ ($goodReportsCount + $decentReportsCount + $badReportsCount) }}"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decent -->
                                <div class="col-12 col-lg border-bottom border-bottom-lg-0 text-truncate {{ (__('lang_dir') == 'rtl' ? 'border-left-lg' : 'border-right-lg') }}">
                                    <div class="px-1 py-4">
                                        <div class="d-flex align-items-center pb-1">
                                            @include('icons.square', ['class' => 'fill-current width-4 height-4 flex-shrink-0 text-warning'])

                                            <div class="flex-grow-1 mx-2 d-flex text-truncate">
                                                <a href="{{ route('reports', ['project' => request()->input('project'), 'result' => 'decent', 'sort_by' => 'result', 'sort' => 'asc']) }}" class="text-secondary font-weight-medium d-flex align-items-center text-truncate">
                                                    <span class="d-inline-block text-truncate">{{ __(($decentReportsCount == 1 ? ':value decent report' : ':value decent reports'), ['value' => number_format($decentReportsCount, 0, __('.'), __(','))]) }}</span>

                                                    @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current flex-shrink-0 '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center text-muted mb-0 text-truncate flex-shrink-0">
                                                {{ number_format($decentReportsCount ? (($decentReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0, 1, __('.'), __(',')) }}%
                                            </div>
                                        </div>

                                        <div class="progress height-1.25 w-100 mt-2">
                                            <div class="progress-bar bg-warning rounded" role="progressbar" style="width: {{ number_format($decentReportsCount ? (($decentReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}%" aria-valuenow="{{ number_format($decentReportsCount ? (($decentReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}" aria-valuemin="0" aria-valuemax="{{ ($goodReportsCount + $decentReportsCount + $badReportsCount) }}"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Good -->
                                <div class="col-12 col-lg text-truncate">
                                    <div class="px-1 py-4">
                                        <div class="d-flex align-items-center pb-1">
                                            @include('icons.circle', ['class' => 'fill-current width-4 height-4 flex-shrink-0 text-success'])

                                            <div class="flex-grow-1 mx-2 d-flex text-truncate">
                                                <a href="{{ route('reports', ['project' => request()->input('project'), 'result' => 'good', 'sort_by' => 'result', 'sort' => 'asc']) }}" class="text-secondary font-weight-medium d-flex align-items-center text-truncate">
                                                    <span class="d-inline-block text-truncate">{{ __(($goodReportsCount == 1 ? ':value good report' : ':value good reports'), ['value' => number_format($goodReportsCount, 0, __('.'), __(','))]) }}</span>

                                                    @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current flex-shrink-0 '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center text-muted mb-0 text-truncate flex-shrink-0">
                                                {{ number_format($goodReportsCount ? (($goodReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0, 1, __('.'), __(',')) }}%
                                            </div>
                                        </div>

                                        <div class="progress height-1.25 w-100 mt-2">
                                            <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{ number_format($goodReportsCount ? (($goodReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}%" aria-valuenow="{{ number_format($goodReportsCount ? (($goodReportsCount / ($goodReportsCount + $decentReportsCount + $badReportsCount)) * 100) : 0) }}" aria-valuemin="0" aria-valuemax="{{ ($goodReportsCount + $decentReportsCount + $badReportsCount) }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">{{ __('Activity') }}</h4>

            <div class="row m-n2">
                <div class="col-12 col-lg-6 p-2">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col"><div class="font-weight-medium py-1">{{ __('Latest reports') }}</div></div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(count($latestReports) == 0)
                                {{ __('No data') }}.
                            @else
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($latestReports as $report)
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col d-flex text-truncate">
                                                    <div class="text-truncate">
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://icons.duckduckgo.com/ip3/{{ parse_url($report->fullUrl, PHP_URL_HOST) }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                            <div class="text-truncate {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}" data-enable="tooltip" title="{{ $report->url }}">
                                                                <a href="{{ route('reports.show', $report->id) }}" dir="ltr">{{ $report->url }}</a>
                                                            </div>

                                                            <span class="d-flex align-items-center">@include('reports.partials.badge')</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                            <div class="text-muted text-truncate small">
                                                                <span class="text-muted" data-enable="tooltip" title="{{ $report->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $report->created_at->diffForHumans() }}</span>
                                                            </div>
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
                                </div>
                            @endif
                        </div>

                        @if(count($latestReports) > 0)
                            <div class="card-footer bg-base-2 border-0">
                                <a href="{{ route('reports') }}" class="text-muted font-weight-medium d-flex align-items-center justify-content-center">{{ __('View all') }} @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-lg-6 p-2">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col"><div class="font-weight-medium py-1">{{ __('Latest projects') }}</div></div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(count($latestProjects) == 0)
                                {{ __('No data') }}.
                            @else
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($latestProjects as $project)
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col d-flex text-truncate">
                                                    <div class="text-truncate">
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://icons.duckduckgo.com/ip3/{{ $project->project }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                            <div class="text-truncate {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">
                                                                <a href="{{ route('reports', ['project' => $project->project]) }}" dir="ltr">{{ $project->project }}</a>
                                                            </div>

                                                            <span class="d-flex align-items-center">
                                                                <a href="{{ route('reports', ['project' => $project->project]) }}" class="d-none d-md-inline-block badge {{ (($project->result / $project->reports) > 79 ? 'badge-success' : (($project->result / $project->reports) > 49 ? 'badge-warning' : 'badge-danger')) }} text-truncate">{{ (($project->result / $project->reports) > 79 ? __('Good') : (($project->result / $project->reports) > 49 ? __('Decent') : __('Bad'))) }}</a>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                            <div class="text-muted text-truncate small">
                                                                <span class="text-muted" data-enable="tooltip" title="{{ $project->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $project->created_at->diffForHumans() }}</span>
                                                            </div>
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
                                </div>
                            @endif
                        </div>

                        @if(count($latestProjects) > 0)
                            <div class="card-footer bg-base-2 border-0">
                                <a href="{{ route('projects') }}" class="text-muted font-weight-medium d-flex align-items-center justify-content-center">{{ __('View all') }} @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'width-3 height-3 fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <h4 class="mb-3 mt-5">{{ __('More') }}</h4>

            <div class="row m-n2">
                <div class="col-12 col-xl-4 p-2">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body d-flex">
                            <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-2xl"></div>
                                @include('icons.list-alt', ['class' => 'fill-current width-6 height-6'])
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="{{ route('reports') }}" class="text-dark font-weight-medium text-decoration-none stretched-link">{{ __('Reports') }}</a>

                                <div class="text-muted">
                                    {{ __('Manage the reports.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4 p-2">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body d-flex">
                            <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-2xl"></div>
                                @include('icons.account-tree', ['class' => 'fill-current width-6 height-6'])
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="{{ route('projects') }}" class="text-dark font-weight-medium text-decoration-none stretched-link">{{ __('Projects') }}</a>

                                <div class="text-muted">
                                    {{ __('Manage the projects.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4 p-2">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body d-flex">
                            <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-2xl"></div>
                                @include('icons.handyman', ['class' => 'fill-current width-6 height-6'])
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="{{ route('tools') }}" class="text-dark font-weight-medium text-decoration-none stretched-link">{{ __('Tools') }}</a>

                                <div class="text-muted">
                                    {{ __('Manage the tools.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-12 col-xl-4 p-2">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body d-flex">
                            <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-2xl"></div>
                                @include('icons.credit-card', ['class' => 'fill-current width-6 height-6'])
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="https://checkseo.org/pages/business-model" class="text-dark font-weight-medium text-decoration-none stretched-link">{{ __('Donate') }}</a>

                                <div class="text-muted">
                                    {{ __('Pay what you want.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(config('settings.ad_dashboard_bottom'))
                <div class="d-print-none mt-3">{!! config('settings.ad_dashboard_bottom') !!}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@include('shared.sidebars.user')