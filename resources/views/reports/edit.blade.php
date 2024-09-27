@section('site_title', formatTitle([__('Edit'), __('Report'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => request()->is('admin/*') ? route('admin.dashboard') : route('dashboard'), 'title' => request()->is('admin/*') ? __('Admin') : __('Home')],
    ['title' => __('Edit')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('Edit') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Report') }}</div>
            </div>
            <div class="col-auto d-flex">
                <div class="form-row">
                    <div class="col">
                        @include('reports.partials.menu')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ request()->is('admin/*') ? route('admin.reports.edit', $report->id) : route('reports.edit', $report->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            @if(request()->is('admin/*'))
                <input type="hidden" name="user_id" value="{{ $report->user->id }}">
            @endif

            <div class="form-group">
                <label for="i-url">{{ __('URL') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img src="https://icons.duckduckgo.com/ip3/{{ $report->url }}.ico" rel="noreferrer" class="width-4 height-4"></span>
                    </div>
                    <input type="text" dir="ltr" name="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" id="i-url" value="{{ $report->url }}" disabled>
                    @if ($errors->has('url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('url') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label>{{ __('Privacy') }}</label>
                <div class="form-group mb-0">
                    <div class="form-row">
                        <div class="col-12 col-lg-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="i-privacy1" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="1" @if($report->privacy == 1 && old('privacy') == null || old('privacy') == 1) checked @endif>
                                <label class="custom-control-label cursor-pointer w-100" for="i-privacy1">
                                    <div>{{ __('Private') }}</div>
                                    <div class="small text-muted">{{ __('Stats accessible only by you.') }}</div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="i-privacy0" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="0" @if($report->privacy == 0 && old('privacy') == null || old('privacy') == 0 && old('privacy') != null) checked @endif>
                                <label class="custom-control-label cursor-pointer w-100" for="i-privacy0">
                                    <div>{{ __('Public') }}</div>
                                    <div class="small text-muted">{{ __('Stats accessible by anyone.') }}</div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="i-privacy2" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="2" @if($report->privacy == 2 && old('privacy') == null || old('privacy') == 2) checked @endif>
                                <label class="custom-control-label cursor-pointer w-100" for="i-privacy2">
                                    <div>{{ __('Password') }}</div>
                                    <div class="small text-muted">{{ __('Stats accessible by password.') }}</div>
                                </label>

                                <div id="input-password" class="{{ (((old('privacy') == 2) || (old('privacy') == null && $report->privacy == 2)) ? '' : 'd-none')}}">
                                    <div class="input-group mt-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text cursor-pointer" data-enable="tooltip" data-title="{{ __('Show password') }}" data-password="i-password" data-password-show="{{ __('Show password') }}" data-password-hide="{{ __('Hide password') }}">@include('icons.lock', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                        </div>
                                        <input id="i-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ request()->is('admin/*') ? '' : (old('password') ?? $report->password) }}" autocomplete="new-password" @if(request()->is('admin/*')) disabled @endif>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('privacy'))
                        <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('privacy') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>

@if(request()->is('admin/*'))
    @include('admin.users.partials.card', ['user' => $report->user])
@endif