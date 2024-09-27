@section('site_title', formatTitle([__('DNS lookup'), __('Tool'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('tools'), 'title' => __('Tools')],
    ['title' => __('Tool')],
]])

<div class="d-flex">
    <h1 class="h2 mb-3 text-break">{{ __('DNS lookup') }}</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('DNS lookup') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('tools.dns_lookup')  }}" method="post" enctype="multipart/form-data">
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
                    <a href="{{ route('tools.dns_lookup') }}" class="btn btn-outline-secondary ml-auto">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($results))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col">
                    <div class="font-weight-medium py-1">{{ __('Result') }}</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(empty($results))
                {{ __('No results found.') }}
            @else
                <ul class="nav nav-pills d-flex flex-fill flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link active" id="pills-dns-a-tab" data-toggle="pill" href="#pills-dns-a" role="tab" aria-controls="pills-dns-a" aria-selected="true">{{ __('A') }}</a>
                    </li>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link" id="pills-dns-aaaa-tab" data-toggle="pill" href="#pills-dns-aaaa" role="tab" aria-controls="pills-dns-aaaa" aria-selected="false">{{ __('AAAA') }}</a>
                    </li>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link" id="pills-dns-cname-tab" data-toggle="pill" href="#pills-dns-cname" role="tab" aria-controls="pills-dns-cname" aria-selected="false">{{ __('CNAME') }}</a>
                    </li>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link" id="pills-dns-mx-tab" data-toggle="pill" href="#pills-dns-mx" role="tab" aria-controls="pills-dns-mx" aria-selected="false">{{ __('MX') }}</a>
                    </li>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link" id="pills-dns-txt-tab" data-toggle="pill" href="#pills-dns-txt" role="tab" aria-controls="pills-dns-txt" aria-selected="false">{{ __('TXT') }}</a>
                    </li>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link" id="pills-dns-ns-tab" data-toggle="pill" href="#pills-dns-ns" role="tab" aria-controls="pills-dns-ns" aria-selected="false">{{ __('NS') }}</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dns-a" role="tabpanel" aria-labelledby="pills-dns-a-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('IP') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'a')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['ip'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-dns-aaaa" role="tabpanel" aria-labelledby="pills-dns-aaaa-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('IPv6') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'aaaa')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['ipv6'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-dns-cname" role="tabpanel" aria-labelledby="pills-dns-cname-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Target') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'cname')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['target'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-dns-mx" role="tabpanel" aria-labelledby="pills-dns-mx-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-3 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-3 text-truncate">{{ __('Target') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Priority') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'mx')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-3 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-3 text-break">{{ $result['target'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['pri'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-dns-txt" role="tabpanel" aria-labelledby="pills-dns-txt-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Entries') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'txt')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">
                                                @foreach($result['entries'] as $entry)
                                                    <div class="text-break {{ !$loop->first ? 'mt-1' : '' }}">{{ $entry }}</div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-dns-ns" role="tabpanel" aria-labelledby="pills-dns-ns-tab">
                        <div class="list-group list-group-flush mb-n3">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center text-muted">
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('Type') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Hostname') }}</div>
                                    <div class="col-12 col-lg-4 text-truncate">{{ __('Target') }}</div>
                                    <div class="col-12 col-lg-2 text-truncate">{{ __('TTL') }}</div>
                                </div>
                            </div>

                            @foreach($results as $result)
                                @if(strtolower($result['type']) == 'ns')
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center text-muted">
                                            <div class="col-12 col-lg-2 text-break">{{ $result['type'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['host'] }}</div>
                                            <div class="col-12 col-lg-4 text-break">{{ $result['target'] }}</div>
                                            <div class="col-12 col-lg-2 text-break">{{ $result['ttl'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif