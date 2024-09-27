@section('site_title', formatTitle([__('URL parser'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('URL parser') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('URL parser') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')
        
        <form action="{{ route('tools.url_parser')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-url">{{ __('URL') }}</label>
                <input type="text" name="url" id="i-url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ $url ?? (old('url') ?? '') }}">

                @if ($errors->has('url'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Parse') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.url_parser') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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

        <div class="card-body">
            @if(empty($results))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    @foreach($results as $key => $value)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 text-break"><code>{{ $key }}</code></div>
                                <div class="col-12 col-lg-8 text-break">{{ $value }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif