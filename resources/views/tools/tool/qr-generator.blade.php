@section('site_title', formatTitle([__('QR generator'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 content-break">{{ __('QR generator') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('QR generator') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.qr_generator')  }}" method="post" enctype="multipart/form-data">
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
            
            <div class="form-group">
                <label for="i-size">{{ __('Size') }}</label>
                <input type="number" name="size" id="i-size" class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" value="{{ $size ?? (old('size') ?? '200') }}">
                @if ($errors->has('size'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('size') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.qr_generator') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
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
                <label>{{ __('QR code') }}</label>

                <div id="qr-code">
                    {!! QrCode::encoding('UTF-8')->size($size)->margin(0)->generate($result); !!}
                </div>

                <button type="button" class="btn btn-primary mt-3" id="qr-download">{{ __('Download') }}</button>

                <canvas id="qr-canvas" width="{{ $size }}" height="{{ $size }}" class="d-none"></canvas>
            </div>
        </div>
    </div>
@endif

<script>
    'use strict';

    let initiateDownload = (imgURI) => {
        var evt = new MouseEvent('click', {
            view: window,
            bubbles: false,
            cancelable: true
        });

        let a = document.createElement('a');
        a.setAttribute('download', 'qr.png');
        a.setAttribute('href', imgURI);
        a.setAttribute('target', '_blank');

        a.dispatchEvent(evt);
    }

    document.querySelector('#qr-download').addEventListener('click', function () {
        let canvas = document.querySelector('#qr-canvas');
        let ctx = canvas.getContext('2d');
        let data = (new XMLSerializer()).serializeToString(document.querySelector('#qr-code > svg'));
        let DOMURL = window.URL || window.webkitURL || window;

        let img = new Image();
        let svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
        let url = DOMURL.createObjectURL(svgBlob);

        img.onload = function () {
            ctx.drawImage(img, 0, 0);
            DOMURL.revokeObjectURL(url);

            var imgURI = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');

            initiateDownload(imgURI);
        };

        img.src = url;
    });
</script>