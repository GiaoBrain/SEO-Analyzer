@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Inline CSS') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The webpage does not contain inline CSS code.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'failed')
                                            {{ __('The webpage contains inline CSS code.') }}

                                            <div class="list-group small mt-2">
                                                <div class="list-group-item p-0">
                                                    <a href="#collapse-inline-css" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-inline-css">
                                                        <div class="font-weight-medium">{{ __('Attributes') }}</div>
                                                        <span class="badge badge-secondary badge-pill">{{ number_format(count($details), 0, __('.'), __(',')) }}</span>
                                                    </a>

                                                    <div class="px-3 collapse" id="collapse-inline-css">
                                                        <div class="pb-2">
                                                            <ol class="mb-0">
                                                                @foreach($details as $value)
                                                                    <li class="py-1"><code>{{ $value }}</code></li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
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
                {{ __('The style attribute contains CSS style rules that are applied to the element.') }} {{ __('Inline CSS code unnecessarily increases the webpage\'s size, and can be moved in an external CSS file.') }}

                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/style" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Mozilla @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif