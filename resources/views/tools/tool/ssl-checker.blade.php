@section('site_title', formatTitle([__('SSL checker'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('SSL checker') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('SSL checker') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.ssl_checker')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-domain">{{ __('Domain') }}</label>
                <input type="text" name="domain" id="i-domain" class="form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}" value="{{ $domain ?? (old('domain') ?? '') }}">

                @if ($errors->has('domain'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('domain') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.ssl_checker') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($result))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(empty($result))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-truncate text-muted">{{ __('Domain') }}</div>
                            <div class="col-12 col-lg-8 text-truncate d-flex align-items-center">
                                <img src="https://icons.duckduckgo.com/ip3/{{ $domain }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                <span dir="ltr">{{ $domain }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-truncate text-muted">{{ __('Status') }}</div>
                            <div class="col-12 col-lg-8 text-truncate d-flex align-items-center">
                                @if($result->isValid())
                                    <div class="bg-success width-4 height-4 rounded-circle {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>

                                    <div class="text-truncate">{{ __('Valid') }}</div>
                                @else
                                    <div class="bg-danger width-4 height-4 rounded-circle {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>

                                    <div class="text-truncate">{{ __('Invalid') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Issuer') }}</div>
                            <div class="col-12 col-lg-8 text-break">{{ $result->getIssuer() }}</div>
                        </div>
                    </div>

                    @if(!empty($result->getOrganization()))
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 text-break text-muted">{{ __('Organization') }}</div>
                                <div class="col-12 col-lg-8 text-break">{{ $result->getOrganization() }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Signature algorithm') }}</div>
                            <div class="col-12 col-lg-8 text-break">{{ $result->getSignatureAlgorithm() }}</div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Issued date') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                {{ __(':date at :time (UTC :offset)', ['date' => $result->validFromDate()->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => $result->validFromDate()->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('H:i:s')), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Expiration date') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                {{ __(':date at :time (UTC :offset)', ['date' => $result->expirationDate()->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => $result->expirationDate()->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('H:i:s')), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif