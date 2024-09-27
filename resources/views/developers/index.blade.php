@extends('layouts.app')

@section('site_title', formatTitle([__('Developers'), config('settings.title')]))

@section('head_content')

@endsection

@section('content')
    <div class="bg-base-1 flex-fill">
        <div class="container h-100 py-6">

            <div class="text-center">
                <h1 class="h2 mb-3 d-inline-block">{{ __('Developers') }}</h1>
                <div class="m-auto">
                    <p class="text-muted font-weight-normal font-size-lg mb-5">{{ __('Explore our API documentation.') }}</p>
                </div>
            </div>

            @php
                $resources = [
                    [
                        'icon' => 'account-tree',
                        'title' => __('Projects'),
                        'description' => __('Manage the projects.'),
                        'route' => route('developers.projects')
                    ],
                    [
                        'icon' => 'list-alt',
                        'title' => __('Reports'),
                        'description' => __('Manage the reports.'),
                        'route' => route('developers.reports')
                    ],
                    [
                        'icon' => 'portrait',
                        'title' => __('Account'),
                        'description' => __('Manage the account.'),
                        'route' => route('developers.account')
                    ]
                ];
            @endphp

            <div class="row m-n2">
                @foreach($resources as $resource)
                    <div class="col-12 col-sm-6 col-md-4 p-2">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body d-flex">
                                <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                    <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-2xl"></div>
                                    @include('icons.' . $resource['icon'], ['class' => 'fill-current width-6 height-6'])
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="{{ $resource['route'] }}" class="text-dark font-weight-medium text-decoration-none stretched-link">{{ $resource['title'] }}</a>

                                    <div class="text-muted">
                                        {{ $resource['description'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('shared.sidebars.user')