@section('site_title', formatTitle([__('Password generator'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Password generator') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Password generator') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.password_generator')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-length">{{ __('Length') }}</label>
                <input type="number" name="length" id="i-length" class="form-control{{ $errors->has('length') ? ' is-invalid' : '' }}" value="{{ $length ?? (old('length') ?? '6') }}">
                @if ($errors->has('length'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('length') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input{{ $errors->has('lower_case') ? ' is-invalid' : '' }}" name="lower_case" id="i-lower-case" value="1" @if(old('lowerCase') || !isset($lowerCase) || $lowerCase) checked @endif>
                    <label class="custom-control-label" for="i-lower-case">{{ __('Lower case') }}</label>
                    @if ($errors->has('lower_case'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('lower_case') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input{{ $errors->has('upper_case') ? ' is-invalid' : '' }}" name="upper_case" id="i-upper-case" value="1" @if(old('upperCase') || !isset($upperCase) || $upperCase) checked @endif>
                    <label class="custom-control-label" for="i-upper-case">{{ __('Upper case') }}</label>
                    @if ($errors->has('upper_case'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('upper_case') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input{{ $errors->has('digits') ? ' is-invalid' : '' }}" name="digits" id="i-digits" value="1" @if(old('digits') || !isset($digits) || $digits) checked @endif>
                    <label class="custom-control-label" for="i-digits">{{ __('Digits') }}</label>
                    @if ($errors->has('digits'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('digits') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input{{ $errors->has('symbols') ? ' is-invalid' : '' }}" name="symbols" id="i-symbols" value="1" @if(old('symbols') || !isset($symbols) || $symbols) checked @endif>
                    <label class="custom-control-label" for="i-symbols">{{ __('Symbols') }}</label>
                    @if ($errors->has('symbols'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('symbols') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.password_generator') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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
        <div class="card-body mb-n3">
            <div class="form-group">
                <label for="i-result-content">{{ __('Content') }}</label>

                <div class="position-relative">
                    <textarea name="result-content" id="i-result-content" class="form-control" onclick="this.select();" readonly>{{ $result }}</textarea>

                    <div class="position-absolute top-0 right-0">
                        <div class="btn btn-sm btn-primary m-2" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-result-content">{{ __('Copy') }}</div>
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