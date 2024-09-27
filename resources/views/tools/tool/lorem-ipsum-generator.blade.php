@section('site_title', formatTitle([__('Lorem ipsum generator'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Lorem ipsum generator') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Lorem ipsum generator') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.lorem_ipsum_generator')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-type">{{ __('Type') }}</label>
                <select name="type" id="i-type" class="custom-select{{ $errors->has('type') ? ' is-invalid' : '' }}">
                    @foreach(['paragraphs' => __('Paragraphs'), 'sentences' => __('Sentences'), 'words' => __('Words')] as $key => $value)
                        <option value="{{ $key }}" @if (isset($type) && $type == $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('type'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i-number">{{ __('Number') }}</label>
                <input type="number" name="number" id="i-number" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" value="{{ $number ?? (old('number') ?? '5') }}">
                @if ($errors->has('number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.lorem_ipsum_generator') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>
        <div class="card-body mb-n3">
            <div class="form-group">
                <label for="i-result-content">{{ __('Content') }}</label>

                <div class="position-relative">
                        <textarea rows="5" name="result-content" id="i-result-content" class="form-control" onclick="this.select();" readonly>@foreach($results as $block)
{{ $block }}@if(!$loop->last)


@endif
@endforeach</textarea>

                    <div class="position-absolute top-0 right-0">
                        <div class="btn btn-sm btn-primary m-2" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-result">{{ __('Copy') }}</div>
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