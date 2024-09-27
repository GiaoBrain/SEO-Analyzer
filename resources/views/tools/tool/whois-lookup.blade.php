@section('site_title', formatTitle([__('WHOIS lookup'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('WHOIS lookup') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('WHOIS lookup') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.whois_lookup')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i-domain">{{ __('Domain') }}</label>
                <input type="text" name="domain" id="i-domain" class="form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}" value="{{ $domain ?? (old('domain') ?? '') }}">

                @if ($errors->has('domain'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('domain') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tools.whois_lookup') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($result))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(empty($result))
                {{ __('No results found.') }}
            @else
                <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Domain') }}</div>
                            <div class="col-12 col-lg-8 text-break d-flex align-items-center">
                                <img src="https://icons.duckduckgo.com/ip3/{{ $result->domainName }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                <span dir="ltr">{{ $result->domainName }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Registrar') }}</div>
                            <div class="col-12 col-lg-8 text-break">{{ $result->registrar }}</div>
                        </div>
                    </div>

                    @if($result->owner)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 text-break text-muted">{{ __('Registrant') }}</div>
                                <div class="col-12 col-lg-8 text-break">{{ $result->owner }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Created date') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                {{ __(':date at :time (UTC :offset)', ['date' => \Carbon\Carbon::createFromTimestamp($result->creationDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => \Carbon\Carbon::createFromTimestamp($result->creationDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('H:i:s')), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Updated date') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                {{ __(':date at :time (UTC :offset)', ['date' => \Carbon\Carbon::createFromTimestamp($result->updatedDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => \Carbon\Carbon::createFromTimestamp($result->updatedDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('H:i:s')), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Expiration date') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                {{ __(':date at :time (UTC :offset)', ['date' => \Carbon\Carbon::createFromTimestamp($result->expirationDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')), 'time' => \Carbon\Carbon::createFromTimestamp($result->expirationDate)->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('H:i:s')), 'offset' => \Carbon\CarbonTimeZone::create((Auth::user()->timezone ?? config('app.timezone')))->toOffsetName()]) }}
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('Name servers') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                @foreach($result->nameServers as $nameServer)
                                    <div class="text-break {{ !$loop->first ? 'mt-1' : '' }}">
                                        {{ $nameServer }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-break text-muted">{{ __('States') }}</div>
                            <div class="col-12 col-lg-8 text-break">
                                @foreach($result->states as $state)
                                    <div class="text-break {{ !$loop->first ? 'mt-1' : '' }}">
                                        {{ $state }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($result->whoisServer)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 text-break text-muted">{{ __('WHOIS server') }}</div>
                                <div class="col-12 col-lg-8 text-break">{{ $result->whoisServer }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif