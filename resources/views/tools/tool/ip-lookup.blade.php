@section('site_title', formatTitle([__('IP lookup'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('IP lookup') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('IP lookup') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.ip_lookup')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-ip">{{ __('IP') }}</label>
                <div class="input-group">
                    <input type="text" name="ip" id="i-ip" class="form-control{{ $errors->has('ip') || isset($result) && empty($result) ? ' is-invalid' : '' }}" value="{{ $result['traits']['ip_address'] ?? (old('ip') ?? request()->ip()) }}">
                    <div class="input-group-append">
                        <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-ip">{{ __('Copy') }}</div>
                    </div>
                </div>

                @if ($errors->has('ip'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('ip') }}</strong>
                    </span>
                @elseif(isset($result) && empty($result))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ __('No results.') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.ip_lookup') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(!empty($result))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>
        <div class="card-body mb-n3">
            <div class="form-row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-country">{{ __('Country') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <img src="{{ asset('/images/icons/countries/'. mb_strtolower($result['country']['iso_code'] ?? 'unknown')) }}.svg" class="width-4 height-4">
                                </div>
                            </div>
                            <input id="i-country" class="form-control" type="text" value="{{ __($result['country']['names']['en'] ?? 'Unknown') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-city">{{ __('City') }}</label>
                        <input id="i-city" class="form-control" type="text" value="{{ __($result['city']['names']['en'] ?? 'Unknown') }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-postal-code">{{ __('Postal code') }}</label>
                        <input id="i-postal-code" class="form-control" type="text" value="{{ __($result['postal']['code'] ?? 'Unknown') }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-latitude">{{ __('Latitude') }}</label>
                        <input id="i-latitude" class="form-control" type="text" value="{{ __($result['location']['latitude'] ?? 'Unknown') }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-longitude">{{ __('Longtitude') }}</label>
                        <input id="i-longitude" class="form-control" type="text" value="{{ __($result['location']['longitude'] ?? 'Unknown') }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="i-timezone">{{ __('Timezone') }}</label>
                        <input id="i-timezone" class="form-control" type="text" value="{{ __($result['location']['time_zone'] ?? 'Unknown') }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>