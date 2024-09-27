@section('site_title', formatTitle([__('UUID generator'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('UUID generator') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('UUID generator') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')
        
        <form action="{{ route('tools.uuid_generator')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-uuid-generator" class="d-inline-flex align-items-center"><span class="{{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">{{ __('UUID') }}</span><span class="badge badge-secondary">{{ __('v4') }}</span></label>
                <div class="input-group">
                    <input type="text" name="uuid_generator" id="i-uuid-generator" class="form-control" value="{{ Str::uuid() }}">
                    <div class="input-group-append">
                        <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i-uuid-generator">{{ __('Copy') }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Regenerate') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>