@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Structured data') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The webpage has structured data.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'missing')
                                            {{ __('There are no structured data tags on the webpage.') }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            <div class="list-group small mt-2">
                                @foreach($report['results'][$name]['value'] as $key => $value)
                                    <div class="list-group-item p-0">
                                        <a href="#collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}">
                                            <div class="font-weight-medium">{{ $key }}</div>
                                            <span class="badge badge-secondary badge-pill">{{ number_format(count($report['results'][$name]['value'][$key]), 0, __('.'), __(',')) }}</span>
                                        </a>

                                        <div class="px-3 collapse" id="collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}">
                                            <div class="pb-2">
                                                {{ arrayToHtml($value, ['<ol class="mb-0">', '</ol>'], ['<ul>', '</ul>'], ['<li class="py-1 text-break">', '</li>'], ['<span class="font-weight-medium">', '</span> '], ['<span class="text-muted">', '</span>']) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="#collapse{{ $name }}" class="text-secondary" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse{{ $name }}" data-enable="tooltip" title="{{ __('More') }}">
                        @include('icons.info', ['class' => 'fill-current width-4 height-4'])&#8203;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="collapse{{ Auth::check() && Auth::user()->default_export_detailed ? ' d-print-block' : '' }}" id="collapse{{ $name }}">
        <div class="card-body pt-0">
            <div class="alert alert-secondary mb-0">
                {{ __('The structured data tags help the search engines better understand the content of the webpage, and allows them to create rich snippets in search results.') }}

                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>

                    <div class="col-12 col-md-auto">
                        <a href="https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Twitter @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://schema.org/" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Schema.org @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://ogp.me/" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Open Graph @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://www.bing.com/webmasters/help/marking-up-your-site-with-structured-data-3a93e731" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Bing @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://developers.google.com/search/docs/advanced/structured-data/intro-structured-data" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Google @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif