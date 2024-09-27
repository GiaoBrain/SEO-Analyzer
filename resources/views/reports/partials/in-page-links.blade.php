@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('In-page links') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The number of links on the webpage is okay.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'too_many')
                                            {{ __('The webpage contains more than :value links.', ['value' => number_format($details['max'], 0, __('.'), __(','))]) }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            @if($report['results'][$name]['value'])
                                <div class="list-group small mt-2">
                                    @foreach($report['results'][$name]['value'] as $key => $value)
                                        <div class="list-group-item p-0">
                                            <a href="#collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}}">
                                                <div class="font-weight-medium">{{ __($key) }}</div>
                                                <span class="badge badge-secondary badge-pill">{{ number_format(count($value), 0, __('.'), __(',')) }}</span>
                                            </a>

                                            <div class="px-3 collapse" id="collapse-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}">
                                                <div class="pb-2">
                                                    <ol class="mb-0">
                                                        @foreach($value as $link)
                                                            <li class="py-1 text-break"><a href="{{ $link['url'] }}" rel="nofollow" target="_blank">{{ $link['text'] ?: $link['url'] }}</a></li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                {{ __('The in-page links should be kept at a minimum, to avoid issues with search engines not being able to crawl additional links from the webpage.') }}
            </div>
        </div>
    </div>
@endif