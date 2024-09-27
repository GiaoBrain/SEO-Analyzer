@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Headings') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The headings are properly set.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'missing')
                                            {{ __('There is no h1 tag on the webpage.') }}
                                        @endif

                                        @if($error == 'too_many')
                                            {{ __('Only one h1 tag should be present on the webpage.') }}
                                        @endif

                                        @if($error == 'duplicate')
                                            {{ __('The h1 tag is the same with the title tag.') }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif

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
                                                    @foreach($value as $heading)
                                                        <li class="py-1 text-break">{{ $heading }}</li>
                                                    @endforeach
                                                </ol>
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
                {{ __('The h tags represents the headings of the webpage.') }} {{ __('The h1 tag is the most important h tag, and describes the main topic of the page, while the rest of the tags describe the sub-topics of the webpage.') }}


                <hr>

                <div class="row">
                    <div class="col-12 col-md">
                        {{ __('Learn more') }}
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Heading_Elements" class="alert-link font-weight-medium d-flex align-items-center" target="_blank" rel="nofollow">Mozilla @include('icons.external', ['class' => 'fill-current width-3 height-3 ' . (__('lang_dir') == 'rtl' ? 'mr-1' : 'ml-1')])</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif