@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Social') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The webpage has :value social links.', ['value' => number_format(array_sum(array_map('count', $report['results'][$name]['value'])), 0, __('.'), __(','))]) }}
                                </div>

                                @if($report['results'][$name]['value'])
                                    <div class="list-group small mt-2">
                                        @foreach($report['results'][$name]['value'] as $key => $value)
                                            <div class="list-group-item p-0">
                                                <a href="#collapse-{{ $key }}" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                    <div class="font-weight-medium">{{ $key }}</div>
                                                    <span class="badge badge-secondary badge-pill">{{ number_format(count($value), 0, __('.'), __(',')) }}</span>
                                                </a>

                                                <div class="px-3 collapse" id="collapse-{{ $key }}">
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
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'missing')
                                            {{ __('The webpage does not contain any social links.') }}
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
                {{ __('Social media presence is becoming increasingly important as a ranking factor for search engines to validate a website\'s trustworthiness and authority.') }}
            </div>
        </div>
    </div>
@endif