@section('site_title', formatTitle([__('User-Agent parser'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('User-Agent parser') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('User-Agent parser') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.user_agent_parser')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-user-agent">{{ __('User-Agent') }}</label>
                <div class="input-group">
                    <input type="text" name="user_agent" id="i-user-agent" class="form-control{{ $errors->has('user_agent') ? ' is-invalid' : '' }}" value="{{ $userAgent ?? (old('user_agent') ?? request()->header('User-Agent')) }}">
                    <div class="input-group-append">
                        <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-user-agent">{{ __('Copy') }}</div>
                    </div>
                </div>

                @if ($errors->has('user_agent'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('user_agent') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Parse') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.user_agent_parser') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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
            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="i-browser">{{ __('Browser') }}</label>
                        <input id="i-browser" class="form-control" type="text" value="{{ $result->browser->name ?? null }} {{ $result->browser->version->value ?? null }}" readonly>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="i-operating-system">{{ __('Operating system') }}</label>
                        <input id="i-operating-system" class="form-control" type="text" value="{{ $result->os->name ?? null }} {{ $result->os->version->value ?? null }}" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="i-result">{{ __('User-Agent') }}</label>

                <div class="position-relative">
                    <textarea name="user-agent" id="i-user-agent" class="form-control" onclick="this.select();" readonly>{{ $userAgent ?? null }}</textarea>

                    <div class="position-absolute top-0 right-0">
                        <div class="btn btn-sm btn-primary m-2" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-user-agent">{{ __('Copy') }}</div>
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