@if(isset($report['results'][$name]))
    <div class="border-top">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="d-flex align-items-center">
                                @include('reports.partials.status')

                                <div class="text-truncate font-weight-medium">{{ __('Plaintext email') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            @if($report['results'][$name]['passed'])
                                <div>
                                    {{ __('The webpage does not contain any plaintext emails.') }}
                                </div>
                            @else
                                @foreach($report['results'][$name]['errors'] as $error => $details)
                                    <div class="{{ (!$loop->first) ? 'mt-3' : ''}}">
                                        @if($error == 'failed')
                                            <div>{{ __('The webpage contains plaintext emails.') }}</div>

                                            <div class="list-group small mt-2">
                                                <div class="list-group-item p-0">
                                                    <a href="#collapse-plaintext-emails" class="d-flex text-secondary justify-content-between align-items-center text-decoration-none px-3 py-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-plaintext-emails">
                                                        <div class="font-weight-medium">{{ __('Emails') }}</div>
                                                        <span class="badge badge-secondary badge-pill">{{ number_format(count($details), 0, __('.'), __(',')) }}</span>
                                                    </a>

                                                    <div class="px-3 collapse" id="collapse-plaintext-emails">
                                                        <div class="pb-2">
                                                            <ol class="mb-0">
                                                                @foreach($details as $email)
                                                                    <li class="py-1">{{ $email }}</li>
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
                {{ __('Email addresses posted in public are likely to be fetched by crawlers and then collected in lists used for spam.') }}
            </div>
        </div>
    </div>
@endif