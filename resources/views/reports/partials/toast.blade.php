@if(request()->session()->get('toast'))
    <div class="position-relative position-lg-fixed z-1001 width-lg-96 top-0 {{ (__('lang_dir') == 'rtl' ? 'left-0' : 'right-0') }}">
        @if(count(request()->session()->get('toast')) > 1)
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div class="toast backdrop-filter-blur fade show border-0 font-size-base mx-lg-3 shadow-sm mt-3 overflow-hidden max-width-full" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                    <div class="toast-header px-1 py-2">
                        <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'pr-2 pl-3' : 'pl-2 pr-3') }}">@include('icons.account-tree', ['class' => 'fill-current width-4 height-4'])</div>
                        <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-auto' : 'mr-auto') }}">{{ __('Project generated') }}</div>
                        <button type="button" class="close d-flex align-items-center justify-content-center p-2" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-4 height-4'])</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        <div class="row align-items-center">
                            <div class="col d-flex text-truncate">
                                <div class="d-flex align-items-center text-truncate">
                                    <img src="https://icons.duckduckgo.com/ip3/{{ request()->session()->get('toast')[0]->project }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                    <a href="{{ route('reports', ['project' => request()->session()->get('toast')[0]->project]) }}" dir="ltr" class="text-truncate">{{ request()->session()->get('toast')[0]->project }}</a>

                                    <div class="badge badge-secondary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ __(':value reports', ['value' => count(request()->session()->get('toast'))]) }}</div>
                                </div>
                            </div>
                            <div class="col-auto d-flex">
                                <div class="form-row">
                                    <div class="col">
                                        <a href="{{ route('reports', ['project' => request()->session()->get('toast')[0]->project]) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach(request()->session()->get('toast') as $report)
                <div aria-live="polite" aria-atomic="true" class="position-relative">
                    <div class="toast backdrop-filter-blur fade show border-0 font-size-base mx-lg-3 shadow-sm mt-3 overflow-hidden max-width-full" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                        <div class="toast-header px-1 py-2">
                            <div class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'pr-2 pl-3' : 'pl-2 pr-3') }}">@include('icons.list-alt', ['class' => 'fill-current width-4 height-4'])</div>
                            <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-auto' : 'mr-auto') }}">{{ __('Report generated') }}</div>
                            <button type="button" class="close d-flex align-items-center justify-content-center p-2" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-4 height-4'])</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <div class="row align-items-center">
                                <div class="col d-flex text-truncate">
                                    <div class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <img src="https://icons.duckduckgo.com/ip3/{{ parse_url($report->fullUrl, PHP_URL_HOST) }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                            <div class="text-truncate {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}" data-enable="tooltip" title="{{ $report->url }}">
                                                <a href="{{ route('reports.show', $report->id) }}" class="text-primary" dir="ltr">{{ $report->url }}</a>
                                            </div>

                                            <span class="d-flex align-items-center">@include('reports.partials.badge')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex">
                                    <div class="form-row">
                                        <div class="col">
                                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif