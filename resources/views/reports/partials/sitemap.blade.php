@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Sitemap') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The website has sitemaps.') }}
                                </div>

                                <div>
                                    @if(!empty($report['results'][$name]['value']))
                                        <div class="list-group small mt-2">
                                            <div class="list-group-item p-0">
                                                <a href="#collapse-sitemaps" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-sitemaps">
                                                    <div class="font-weight-medium">{{ __('Sitemaps') }}</div>
                                                    <span class="badge badge-secondary badge-pill">{{ number_format(count($report['results'][$name]['value']), 0, __('.'), __(',')) }}</span>
                                                </a>

                                                <div class="px-3 collapse" id="collapse-sitemaps">
                                                    <div class="pb-2">
                                                        <ol class="mb-0">
                                                            @foreach($report['results'][$name]['value'] as $link)
                                                                <li class="py-1"><a href="{{ $link }}" class="text-break" rel="nofollow" target="_blank">{{ $link }}</a></li>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'failed')
                                            {{ __('No sitemaps found.') }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif
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
                {{ __('Sitemaps inform search engines about pages available for crawling on the website.') }}

                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://www.bing.com/webmasters/help/sitemaps-3b5cf6ed" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Bing @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://developers.google.com/search/docs/advanced/sitemaps/overview" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Google @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif