@section('site_title', formatTitle([__('Word counter'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Word counter') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Word counter') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.word_counter')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-content">{{ __('Content') }}</label>
                <textarea name="content" id="i-content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ $content ?? (old('content') ?? '') }}</textarea>
                @if ($errors->has('content'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Count') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.word_counter') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($content))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-4 text-truncate text-muted">{{ __('Words') }}</div>
                        <div class="col-12 col-lg-8 text-truncate">{{ number_format($wordCount, 0, __('.'), __(',')) }}</div>
                    </div>
                </div>

                <div class="list-group-item px-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-4 text-truncate text-muted">{{ __('Letters') }}</div>
                        <div class="col-12 col-lg-8 text-truncate">{{ number_format($letterCount, 0, __('.'), __(',')) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif