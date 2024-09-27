@section('site_title', formatTitle([__('Indexed pages checker'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Indexed pages checker') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Indexed pages checker') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.indexed_pages_checker')  }}" method="post" enctype="multipart/form-data" id="indexed-pages-checker-form">
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

            <div class="form-group">
                <label for="i-country">{{ __('Country') }}</label>
                <select name="country" id="i-country" class="custom-select{{ $errors->has('country') ? ' is-invalid' : '' }}">
                    <option value="" hidden disabled selected>{{ __('Country') }}</option>
                    @foreach(array_diff_key(config('countries'), array_flip(['AX', 'BQ', 'CT', 'NQ', 'FQ', 'GG', 'IM', 'JE', 'JT', 'FX', 'MI', 'ME', 'NT', 'VD', 'PC', 'PZ', 'YD', 'BL', 'MF', 'RS', 'PU', 'SU', 'ZZ', 'WK'])) as $key => $value)
                        <option value="{{ $key }}" @if ((isset($country) && $country == $key) || (!isset($country) && old('country') !== null && old('country') == $key) || (!isset($country) && config('settings.gcs_country') == $key && old('country') == null)) selected @endif>{{ __($value) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('country'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    @if(config('settings.captcha_indexed_pages_checker'))
                        {!! NoCaptcha::displaySubmit('indexed-pages-checker-form', __('Send'), ['data-theme' => (Cookie::get('dark_mode') == 1 ? 'dark' : 'light'), 'data-size' => 'invisible', 'class' => 'btn ' . ($errors->has('g-recaptcha-response') ? 'btn-danger' : 'btn-primary')]) !!}

                        {!! NoCaptcha::renderJs(__('lang_code')) !!}
                    @else
                        <button type="submit" name="submit" class="btn btn-primary">{{ __('Search') }}</button>
                    @endif
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.indexed_pages_checker') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>

            @if ($errors->has('g-recaptcha-response'))
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                </span>
            @endif
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
            @elseif(isset($result['error']))
                {{ $result['error']['code'] ?? null }} {{ $result['error']['message'] ?? null }}
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
                                @if($result['searchInformation']['totalResults'] > 0)
                                    <div class="bg-success width-4 height-4 rounded-circle {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>

                                    <div class="text-truncate">{{ __('Indexed') }}</div>
                                @else
                                    <div class="bg-danger width-4 height-4 rounded-circle {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>

                                    <div class="text-truncate">{{ __('Not indexed') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Pages') }}</div>
                            <div class="col-12 col-lg-8 text-break">≈{{ number_format($result['searchInformation']['totalResults'], 0, __('.'), __(',')) }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif