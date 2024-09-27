@include('reports.partials.toast')

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <form action="{{ route('reports.new') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="form-row">
                        <div class="col-12 col-md">
                            <div>
                                <div class="input-group input-group-lg">
                                    <input type="text" dir="ltr" name="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }} font-size-lg" autocapitalize="none" spellcheck="false" id="i-url" value="{{ old('url') }}" placeholder="{{ old('sitemap') ? 'https://example.com/sitemap.xml' : 'https://example.com' }}" data-placeholder-sitemap="{{ 'https://example.com/sitemap.xml' }}" data-placeholder-webpage="{{ 'https://example.com' }}" autofocus>
                                </div>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(config('settings.sitemap_links'))
                            <div class="col-12 col-md-auto mt-3 mt-md-0">
                                <div class="btn-group btn-group-toggle d-flex flex-fill" data-toggle="buttons">
                                    <label class="btn btn-lg font-size-lg btn-outline-primary w-100 d-flex align-items-center justify-content-center @if(old('sitemap') == 0) active @endif" data-enable="tooltip" title="{{ __('Webpage') }}" id="toggle-webpage">
                                        <input type="radio" name="sitemap" value="0" @if(old('sitemap') == 0 || old('sitemap') == null) checked @endif>
                                        @include('icons.list-alt', ['class' => 'width-4 height-4 fill-current'])&#8203;
                                    </label>
                                    <label class="btn btn-lg font-size-lg btn-outline-primary w-100 d-flex align-items-center justify-content-center @if(old('sitemap') == 1) active @endif" data-enable="tooltip" title="{{ __('Sitemap') }}" id="toggle-sitemap">
                                        <input type="radio" name="sitemap" value="1" @if(old('sitemap') == 1) checked @endif>
                                        @include('icons.account-tree', ['class' => 'width-4 height-4 fill-current'])&#8203;
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-auto mt-3 mt-md-0">
                            <div class="form-row">
                                <div class="col-auto order-1 order-md-0">
                                    <a href="#" class="btn btn-lg btn-outline-primary font-size-lg d-flex align-items-center" data-toggle="collapse" data-target="#advanced-options" aria-expanded="false" data-enable="tooltip" title="{{ __('Advanced') }}">@include('icons.settings', ['class' => 'fill-current width-4 height-4'])&#8203;</a>
                                </div>

                                <div class="col order-0 order-md-1">
                                    <button class="btn btn-primary btn-lg btn-block font-size-lg position-relative" type="submit" data-button-loader>
                                        <div class="position-absolute top-0 right-0 bottom-0 left-0 d-flex align-items-center justify-content-center">
                                            <span class="d-none spinner-border spinner-border-sm width-4 height-4" role="status"></span>
                                        </div>
                                        <span class="spinner-text">{{ __('Analyze') }}</span>&#8203;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 collapse{{ ($errors->has('privacy') || $errors->has('password')) ? ' show' : '' }}" id="advanced-options">
                    <div class="form-group mb-0 mt-3">
                        <label>{{ __('Privacy') }}</label>
                        <div class="form-group mb-0">
                            <div class="form-row">
                                <div class="col-12 col-lg-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="i-privacy1" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="1" @if(old('privacy') == null || old('privacy') == 1) checked @elseif(Auth::user()->default_privacy == 1 && old('privacy') == null) checked @endif>
                                        <label class="custom-control-label cursor-pointer w-100 d-flex flex-column" for="i-privacy1">
                                            <span>{{ __('Private') }}</span>
                                            <span class="small text-muted">{{ __('Stats accessible only by you.') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="i-privacy0" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="0" @if(old('privacy') == 0 && old('privacy') != null) checked @elseif(Auth::user()->default_privacy == 0 && old('privacy') == null) checked @endif>
                                        <label class="custom-control-label cursor-pointer w-100 d-flex flex-column" for="i-privacy0">
                                            <span>{{ __('Public') }}</span>
                                            <span class="small text-muted">{{ __('Stats accessible by anyone.') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="i-privacy2" name="privacy" class="custom-control-input{{ $errors->has('privacy') ? ' is-invalid' : '' }}" value="2" @if(old('privacy') == 2) checked @endif>
                                        <label class="custom-control-label cursor-pointer w-100 d-flex flex-column" for="i-privacy2">
                                            <span>{{ __('Password') }}</span>
                                            <span class="small text-muted">{{ __('Stats accessible by password.') }}</span>
                                        </label>
                                        <div id="input-password" class="{{ (old('privacy') != 2 ? 'd-none' : '')}}">
                                            <div class="input-group mt-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text cursor-pointer" data-enable="tooltip" data-title="{{ __('Show password') }}" data-password="i-password" data-password-show="{{ __('Show password') }}" data-password-hide="{{ __('Hide password') }}">@include('icons.lock', ['class' => 'width-4 height-4 fill-current text-muted'])</div>
                                                </div>
                                                <input id="i-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" autocomplete="new-password">
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
                </div>
            </div>
        </form>
    </div>
</div>