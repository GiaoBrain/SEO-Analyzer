@section('site_title', formatTitle([__('Email'), __('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h1 class="h2 mb-3 d-inline-block">{{ __('Ads') }}</h1>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Email') }}</div></div>
    <div class="card-body">

        <ul class="nav nav-pills d-flex flex-fill flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link active" id="pills-dashboard-tab" data-toggle="pill" href="#pills-dashboard" role="tab" aria-controls="pills-dashboard" aria-selected="true">{{ __('Dashboard') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-reports-tab" data-toggle="pill" href="#pills-reports" role="tab" aria-controls="pills-reports" aria-selected="false">{{ __('Reports') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-report-tab" data-toggle="pill" href="#pills-report" role="tab" aria-controls="pills-report" aria-selected="false">{{ __('Report') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-projects-tab" data-toggle="pill" href="#pills-projects" role="tab" aria-controls="pills-projects" aria-selected="false">{{ __('Projects') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-tools-tab" data-toggle="pill" href="#pills-tools" role="tab" aria-controls="pills-tools" aria-selected="false">{{ __('Tools') }}</a>
            </li>

            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-tool-tab" data-toggle="pill" href="#pills-tool" role="tab" aria-controls="pills-tool" aria-selected="false">{{ __('Tool') }}</a>
            </li>
        </ul>

        @include('shared.message')

        <form action="{{ route('admin.settings', 'ads') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel" aria-labelledby="pills-dashboard-tab">
                    <div class="form-group">
                        <label for="i-ad-dashboard-top">{{ __('Top') }}</label>
                        <textarea name="ad_dashboard_top" id="i-ad-dashboard-top" class="form-control{{ $errors->has('ad_dashboard_top') ? ' is-invalid' : '' }}">{{ old('ad_dashboard_top') ?? config('settings.ad_dashboard_top') }}</textarea>
                        @if ($errors->has('ad_dashboard_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_dashboard_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-dashboard-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_dashboard_bottom" id="i-ad-dashboard-bottom" class="form-control{{ $errors->has('ad_dashboard_bottom') ? ' is-invalid' : '' }}">{{ old('ad_dashboard_bottom') ?? config('settings.ad_dashboard_bottom') }}</textarea>
                        @if ($errors->has('ad_dashboard_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_dashboard_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
                    <div class="form-group">
                        <label for="i-ad-reports-top">{{ __('Top') }}</label>
                        <textarea name="ad_reports_top" id="i-ad-reports-top" class="form-control{{ $errors->has('ad_reports_top') ? ' is-invalid' : '' }}">{{ old('ad_reports_top') ?? config('settings.ad_reports_top') }}</textarea>
                        @if ($errors->has('ad_reports_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_reports_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-reports-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_reports_bottom" id="i-ad-reports-bottom" class="form-control{{ $errors->has('ad_reports_bottom') ? ' is-invalid' : '' }}">{{ old('ad_reports_bottom') ?? config('settings.ad_reports_bottom') }}</textarea>
                        @if ($errors->has('ad_reports_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_reports_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-projects" role="tabpanel" aria-labelledby="pills-projects-tab">
                    <div class="form-group">
                        <label for="i-ad-projects-top">{{ __('Top') }}</label>
                        <textarea name="ad_projects_top" id="i-ad-projects-top" class="form-control{{ $errors->has('ad_projects_top') ? ' is-invalid' : '' }}">{{ old('ad_projects_top') ?? config('settings.ad_projects_top') }}</textarea>
                        @if ($errors->has('ad_projects_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_projects_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-projects-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_projects_bottom" id="i-ad-projects-bottom" class="form-control{{ $errors->has('ad_projects_bottom') ? ' is-invalid' : '' }}">{{ old('ad_projects_bottom') ?? config('settings.ad_projects_bottom') }}</textarea>
                        @if ($errors->has('ad_projects_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_projects_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-tools" role="tabpanel" aria-labelledby="pills-tools-tab">
                    <div class="form-group">
                        <label for="i-ad-tools-top">{{ __('Top') }}</label>
                        <textarea name="ad_tools_top" id="i-ad-tools-top" class="form-control{{ $errors->has('ad_tools_top') ? ' is-invalid' : '' }}">{{ old('ad_tools_top') ?? config('settings.ad_tools_top') }}</textarea>
                        @if ($errors->has('ad_tools_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_tools_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-tools-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_tools_bottom" id="i-ad-tools-bottom" class="form-control{{ $errors->has('ad_tools_bottom') ? ' is-invalid' : '' }}">{{ old('ad_tools_bottom') ?? config('settings.ad_tools_bottom') }}</textarea>
                        @if ($errors->has('ad_tools_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_tools_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pills-report" role="tabpanel" aria-labelledby="pills-report-tab">
                    <div class="form-group">
                        <label for="i-ad-report-top">{{ __('Top') }}</label>
                        <textarea name="ad_report_top" id="i-ad-report-top" class="form-control{{ $errors->has('ad_report_top') ? ' is-invalid' : '' }}">{{ old('ad_report_top') ?? config('settings.ad_report_top') }}</textarea>
                        @if ($errors->has('ad_report_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_report_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-report-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_report_bottom" id="i-ad-report-bottom" class="form-control{{ $errors->has('ad_report_bottom') ? ' is-invalid' : '' }}">{{ old('ad_report_bottom') ?? config('settings.ad_report_bottom') }}</textarea>
                        @if ($errors->has('ad_report_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_report_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-tool" role="tabpanel" aria-labelledby="pills-tool-tab">
                    <div class="form-group">
                        <label for="i-ad-tool-top">{{ __('Top') }}</label>
                        <textarea name="ad_tool_top" id="i-ad-tool-top" class="form-control{{ $errors->has('ad_tool_top') ? ' is-invalid' : '' }}">{{ old('ad_tool_top') ?? config('settings.ad_tool_top') }}</textarea>
                        @if ($errors->has('ad_tool_top'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_tool_top') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-ad-tool-bottom">{{ __('Bottom') }}</label>
                        <textarea name="ad_tool_bottom" id="i-ad-tool-bottom" class="form-control{{ $errors->has('ad_tool_bottom') ? ' is-invalid' : '' }}">{{ old('ad_tool_bottom') ?? config('settings.ad_tool_bottom') }}</textarea>
                        @if ($errors->has('ad_tool_bottom'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ad_tool_bottom') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>