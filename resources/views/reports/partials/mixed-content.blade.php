@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Mixed content') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('There are no mixed content resources on the webpage.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'failed')
                                            {{ __('There are :value mixed content resources on the webpage.', ['value' => number_format(array_sum(array_map('count', $report['results'][$name]['errors'][$error])), 0, __('.'), __(','))]) }}

                                            <div class="list-group small mt-2">
                                                @foreach($report['results'][$name]['errors'][$error] as $key => $value)
                                                    <div class="list-group-item p-0">
                                                        <a href="#collapse-mixed-content-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-mixed-content-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}">
                                                            <div class="font-weight-medium">{{ __($key) }}</div>
                                                            <span class="badge badge-secondary badge-pill">{{ number_format(count($value), 0, __('.'), __(',')) }}</span>
                                                        </a>

                                                        <div class="px-3 collapse" id="collapse-mixed-content-{{ mb_strtolower(str_replace([' ', '.'], '-', $key)) }}">
                                                            <div class="pb-2">
                                                                <ol class="mb-0">
                                                                    @foreach($value as $source)
                                                                        <li class="py-1 text-break"><a href="{{ $source }}" rel="nofollow" target="_blank">{{ $source ?: __('Empty') }}</a></li>
                                                                    @endforeach
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
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
                {{ __('The mixed content is the content that is loaded over the HTTP connection while the webpage itself was loaded over HTTPS connection.') }}

                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>

                    <div class="col-12 col-md-auto">
                        <a href="https://developer.mozilla.org/en-US/docs/Web/Security/Mixed_content" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Mozilla @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>

                    <div class="col-12 col-md-auto">
                        <a href="https://web.dev/what-is-mixed-content/" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Google @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif