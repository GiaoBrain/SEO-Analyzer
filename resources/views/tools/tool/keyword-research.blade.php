@section('site_title', formatTitle([__('Keyword research'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-truncate">{{ __('Keyword research') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Keyword research') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.keyword_research')  }}" method="post" enctype="multipart/form-data" id="keywords-research-form">
            @csrf

            <div class="form-group">
                <label for="i-keywords">{{ __('Keywords') }}</label>
                <textarea name="keywords" id="i-keywords" class="form-control{{ $errors->has('keywords') ? ' is-invalid' : '' }}" rows="3">{{ $keywords ?? (old('keywords') ?? '') }}</textarea>
                @if ($errors->has('keywords'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('keywords') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('One per line.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-country">{{ __('Country') }}</label>
                <select name="country" id="i-country" class="custom-select{{ $errors->has('country') ? ' is-invalid' : '' }}">
                    @foreach(['' => __('All'), 'au' => 'Australia', 'ca' => 'Canada', 'in' => 'India', 'nz' => 'New Zealand', 'za' => 'South Africa', 'uk' => 'United Kingdom', 'us' => 'United States'] as $key => $value)
                        <option value="{{ $key }}" @if ((isset($country) && $key == $country) || (old('country') !== null && $key == old('country')) || (empty($key) && old('country'))) selected @endif>{{ __($value) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('country'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-currency">{{ __('Currency') }}</label>
                <select name="currency" id="i-currency" class="custom-select{{ $errors->has('currency') ? ' is-invalid' : '' }}">
                    @foreach(['USD', 'EUR', 'GBP', 'AED', 'ALL', 'ANG', 'ARS', 'AUD', 'AWG', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'FJD', 'FKP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LKR', 'MAD', 'MDL', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'QAR', 'RON', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'STD', 'SVC', 'SZL', 'THB', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR'] as $key)
                        <option value="{{ $key }}" @if ((isset($currency) && $key == $currency) || (old('currency') !== null && $key == old('currency')) || (empty($key) && old('currency'))) selected @endif>{{ $key }} - {{ config('currencies.all')[$key] }}</option>
                    @endforeach
                </select>
                @if ($errors->has('currency'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('currency') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    @if(config('settings.captcha_keyword_research'))
                        {!! NoCaptcha::displaySubmit('keywords-research-form', __('Send'), ['data-theme' => (Cookie::get('dark_mode') == 1 ? 'dark' : 'light'), 'data-size' => 'invisible', 'class' => 'btn ' . ($errors->has('g-recaptcha-response') ? 'btn-danger' : 'btn-primary')]) !!}

                        {!! NoCaptcha::renderJs(__('lang_code')) !!}
                    @else
                        <button type="submit" name="submit" class="btn btn-primary">{{ __('Analyze') }}</button>
                    @endif
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.keyword_research') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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

@if(isset($results))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Results') }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(empty($results['data']))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item px-0 text-muted">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12 col-lg-3 text-truncate">
                                        {{ __('Keyword') }}
                                    </div>

                                    <div class="col-12 col-lg-3 text-truncate">
                                        {{ __('Search volume') }}
                                    </div>

                                    <div class="col-12 col-lg-3 text-truncate">
                                        {{ __('Cost per click') }}
                                    </div>

                                    <div class="col-12 col-lg-3 text-truncate">
                                        {{ __('Competition') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="invisible btn btn-sm btn-outline-primary">{{ __('Copy') }}</div>
                            </div>
                        </div>
                    </div>

                    @foreach($results['data'] as $keyword)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-lg-3 text-truncate">
                                            {{ $keyword['keyword'] }}
                                        </div>

                                        <div class="col-12 col-lg-3 text-truncate">
                                            {{ number_format($keyword['vol'], 0, __('.'), __(',')) }}
                                        </div>

                                        <div class="col-12 col-lg-3 text-truncate">
                                            {{ formatMoney($keyword['cpc']['value'], $keyword['cpc']['currency']) }} <span class="text-muted">{{ mb_strtoupper($currency) }}</span>
                                        </div>

                                        <div class="col-12 col-lg-3 text-truncate">
                                            @if($keyword['competition'] >= 0.66)
                                                <span class="text-danger" data-enable="tooltip" title="{{ __('High competition') }}">{{ ($keyword['competition'] * 100) }}%</span>
                                            @elseif($keyword['competition'] >= 0.33)
                                                <span class="text-warning" data-enable="tooltip" title="{{ __('Medium competition') }}">{{ ($keyword['competition'] * 100) }}%</span>
                                            @else
                                                <span class="text-success" data-enable="tooltip" title="{{ __('Low competition') }}">{{ ($keyword['competition'] * 100) }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="btn btn-sm btn-outline-primary keyword-copy" data-enable="tooltip-keyword" data-value="{{ $keyword['keyword'] }}" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}">{{ __('Copy') }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        jQuery('[data-enable="tooltip-keyword"]').tooltip({animation: true});

        document.querySelectorAll('[data-enable="tooltip-keyword"]').forEach(function (element) {
            element.addEventListener('click', function (e) {
                // Update the tooltip
                jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.copied).tooltip('show');
            });

            element.addEventListener('mouseleave', function () {
                this.setAttribute('data-original-title', this.dataset.copy);
            });
        });

        document.querySelectorAll('.keyword-copy').forEach(function (element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();

                try {
                    let value = this.dataset.value;
                    let tempInput = document.createElement('input');

                    document.body.append(tempInput);

                    // Set the input's value to the url to be copied
                    tempInput.value = value;

                    // Select the input's value to be copied
                    tempInput.select();

                    // Copy the url
                    document.execCommand("copy");

                    // Remove the temporary input
                    tempInput.remove();
                } catch (e) {}
            });
        });
    });
</script>