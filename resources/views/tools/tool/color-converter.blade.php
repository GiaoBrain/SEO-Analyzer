@section('site_title', formatTitle([__('Color converter'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Color converter') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Color converter') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.color_converter')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-color">{{ __('Color') }}</label>
                <input type="text" name="color" id="i-color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" value="{{ $color ?? (old('color') ?? '') }}">

                @if ($errors->has('color'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('color') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Convert') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.color_converter') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
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
            @if(empty($results))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    @foreach($results as $key => $value)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 text-break d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded width-4 height-4 flex-shrink-0 mr-2" style="background: {{ str_replace(',', ', ', $value) }};"></div>
                                            <code>{{ $key }}</code>
                                        </div>
                                        <div class="col-12 col-lg-8 text-break"><code>{{ str_replace(',', ', ', $value) }}</code></div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="btn btn-sm btn-outline-primary keyword-copy" data-enable="tooltip-keyword" data-value="{{ $value }}" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}">{{ __('Copy') }}</div>
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