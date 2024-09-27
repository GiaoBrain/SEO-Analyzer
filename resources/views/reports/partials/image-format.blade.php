@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Image format') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The images are served in the :format format.', ['format' => implode(', ', $report['results'][$name]['value'])]) }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'bad_format')
                                            {{ __('There are :value images that are not using the :format format.', ['value' => number_format(count($details), 0, __('.'), __(',')), 'format' => implode(', ', $report['results'][$name]['value'])]) }}
                                        @endif

                                        <div class="list-group small mt-2">
                                            <div class="list-group-item p-0">
                                                <a href="#collapse-image-format" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-image-format">
                                                    <div class="font-weight-medium">{{ __('Images') }}</div>
                                                    <span class="badge badge-secondary badge-pill">{{ number_format(count($details), 0, __('.'), __(',')) }}</span>
                                                </a>

                                                <div class="px-3 collapse" id="collapse-image-format">
                                                    <div class="pb-2">
                                                        <ol class="mb-0">
                                                            @foreach($details as $image)
                                                                <li class="py-1"><a href="{{ $image['url'] }}" class="text-break" rel="nofollow" target="_blank">{{ $image['url'] }}</a></li>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                {{ __('The images format represents the images that are not served in a next-generation file format.') }} {{ __('Images served in a next-generation format improve the webpage\'s load performance.') }}

                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://web.dev/uses-webp-images/" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Google @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif