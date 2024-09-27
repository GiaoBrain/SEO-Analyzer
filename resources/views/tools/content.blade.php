@extends('layouts.app')

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="container py-3 my-3">
        @if(config('settings.ad_tool_top'))
            <div class="d-print-none mb-1">{!! config('settings.ad_tool_top') !!}</div>
        @endif

        <div class="row">
            <div class="col-12">
                @include('tools.tool.' . $view)
            </div>
        </div>

        @if(config('settings.ad_tool_bottom'))
            <div class="d-print-none mt-3">{!! config('settings.ad_tool_bottom') !!}</div>
        @endif
    </div>
</div>
@endsection

@include('shared.sidebars.user')