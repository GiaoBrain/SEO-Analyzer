@extends('layouts.app')

@section('site_title', formatTitle([__('Tools'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                @if(config('settings.ad_projects_top'))
                    <div class="d-print-none mb-1">{!! config('settings.ad_projects_top') !!}</div>
                @endif

                @include('shared.breadcrumbs', ['breadcrumbs' => [
                    ['url' => route('dashboard'), 'title' => __('Home')],
                    ['title' => __('Tools')],
                ]])

                <div class="d-flex align-items-end">
                    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ __('Tools') }}</h1>
                </div>

                @php
                    if(config('settings.gcs')) {
                        $tools['SEO'][] = [
                                'icon' => 'manage-search',
                                'title' => __('SERP checker'),
                                'route' => route('tools.serp_checker')
                            ];
                        $tools['SEO'][] = [
                                'icon' => 'find-in-page',
                                'title' => __('Indexed pages checker'),
                                'route' => route('tools.indexed_pages_checker')
                            ];
                    }
                    if(config('settings.ke')) {
                        $tools['SEO'][] = [
                            'icon' => 'abc',
                            'title' => __('Keyword research'),
                            'route' => route('tools.keyword_research')
                        ];
                    }
                    $tools['Utilities'][] = [
                            'icon' => 'wifi-tethering',
                            'title' => __('Website status checker'),
                            'route' => route('tools.website_status_checker')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'lock',
                            'title' => __('SSL checker'),
                            'route' => route('tools.ssl_checker')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'info',
                            'title' => __('WHOIS lookup'),
                            'route' => route('tools.whois_lookup')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'dns',
                            'title' => __('DNS lookup'),
                            'route' => route('tools.dns_lookup')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'travel-explore',
                            'title' => __('IP lookup'),
                            'route' => route('tools.ip_lookup')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'password',
                            'title' => __('Password generator'),
                            'route' => route('tools.password_generator')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'js',
                            'title' => __('JS minifier'),
                            'route' => route('tools.js_minifier')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'css',
                            'title' => __('CSS minifier'),
                            'route' => route('tools.css_minifier')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'html',
                            'title' => __('HTML minifier'),
                            'route' => route('tools.html_minifier')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'qr',
                            'title' => __('QR generator'),
                            'route' => route('tools.qr_generator')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'tab',
                            'title' => __('User-Agent parser'),
                            'route' => route('tools.user_agent_parser')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'tag',
                            'title' => __('MD5 generator'),
                            'route' => route('tools.md5_generator')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'style',
                            'title' => __('Color converter'),
                            'route' => route('tools.color_converter')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'dataset-linked',
                            'title' => __('URL parser'),
                            'route' => route('tools.url_parser')
                        ];
                    $tools['Utilities'][] = [
                            'icon' => 'view-stream',
                            'title' => __('UUID generator'),
                            'route' => route('tools.uuid_generator')
                        ];
                    $tools['Content'][] = [
                            'icon' => 'notes',
                            'title' => __('Lorem ipsum generator'),
                            'route' => route('tools.lorem_ipsum_generator')
                        ];
                    $tools['Content'][] = [
                            'icon' => '123',
                            'title' => __('Word counter'),
                            'route' => route('tools.word_counter')
                        ];
                    $tools['Content'][] = [
                            'icon' => 'expand',
                            'title' => __('Case converter'),
                            'route' => route('tools.case_converter')
                        ];
                    $tools['Content'][] = [
                            'icon' => 'link',
                            'title' => __('Text to slug'),
                            'route' => route('tools.text_to_slug')
                        ];
                    $tools['Content'][] = [
                            'icon' => 'url',
                            'title' => __('URL converter'),
                            'route' => route('tools.url_converter')
                        ];
                    $tools['Content'][] = [
                            'icon' => 'border-bottom',
                            'title' => __('Base64 converter'),
                            'route' => route('tools.base64_converter')
                        ];
                @endphp

                <div class="row m-n2">
                    @foreach($tools as $category => $items)
                        <div class="col-12 p-2 mt-3"><div class="badge badge-{{ ($category == 'SEO' ? 'danger' : ($category == 'Utilities' ? 'success' : 'info')) }}">{{ __($category) }}</div></div>

                        @foreach($items as $tool)
                            <div class="col-12 col-lg-4 p-2">
                                <div class="card border-0 h-100 shadow-sm">
                                    <div class="card-body d-flex align-items-center text-truncate">
                                        <div class="d-flex position-relative text-{{ ($category == 'SEO' ? 'danger' : ($category == 'Utilities' ? 'success' : 'info')) }} width-8 height-8 align-items-center justify-content-center flex-shrink-0">
                                            <div class="position-absolute bg-{{ ($category == 'SEO' ? 'danger' : ($category == 'Utilities' ? 'success' : 'info')) }} opacity-10 top-0 right-0 bottom-0 left-0 border-radius-lg"></div>
                                            @include('icons.' . $tool['icon'], ['class' => 'fill-current width-4 height-4'])
                                        </div>

                                        <a href="{{ $tool['route'] }}" class="text-dark font-weight-medium stretched-link text-decoration-none text-truncate mx-3">{{ $tool['title'] }}</a>

                                        <div class="text-muted d-flex align-items-center text-truncate {{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }}">
                                            @include((__('lang_dir') == 'rtl' ? 'icons.chevron-left' : 'icons.chevron-right'), ['class' => 'flex-shrink-0 width-3 height-3 fill-current mx-2'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        
        @if(config('settings.ad_projects_bottom'))
            <div class="d-print-none mt-3">{!! config('settings.ad_projects_bottom') !!}</div>
        @endif
    </div>
</div>

@endsection
@include('shared.sidebars.user')