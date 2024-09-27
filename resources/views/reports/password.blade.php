@extends('layouts.app')

@section('site_title', __('Website protected'))

@section('content')
    <div class="bg-base-1 d-flex align-items-center flex-fill">
        <div class="container py-6">
            <div class="row h-100 justify-content-center align-items-center py-3">
                <div class="col-lg-6">
                    <form action="{{ route('reports.password', ['id' => $report->id]) }}" method="post">
                        @csrf

                        <h1 class="h2 mb-3 text-center">{{ __('Website protected') }}</h1>
                        <p class="mb-5 text-center text-muted">{{ __('This website is password protected.') }}</p>

                        <div class="d-flex mb-5">
                            <div class="flex-grow-1 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                <input id="i-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">{{ __('Validate') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('shared.sidebars.user')