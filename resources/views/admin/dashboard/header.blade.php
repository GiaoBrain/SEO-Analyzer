<div class="bg-base-0">
    <div class="container py-5">
        <div class="d-flex">
            <div class="row no-gutters w-100">
                <div class="d-flex col-12 col-md">
                    <div class="flex-grow-1 d-flex align-items-center">
                        <div>
                            <h1 class="h2 font-weight-medium mb-0">{{ config('settings.title') }}</h1>

                            <div class="d-flex flex-wrap">
                                <div class="d-inline-block mt-2 {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.info', ['class' => 'text-muted fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ config('info.software.url') }}/{{ mb_strtolower(config('info.software.name')) }}/changelog" class="text-dark text-decoration-none d-flex align-items-center" target="_blank">{{ __('Version') }} <span class="badge badge-primary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ config('info.software.version') }}</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-inline-block mt-2 {{ (__('lang_dir') == 'rtl' ? 'ml-4' : 'mr-4') }}">
                                    <div class="d-flex">
                                        <div class="d-inline-flex align-items-center">
                                            @include('icons.vpn-key', ['class' => 'text-muted fill-current width-4 height-4'])
                                        </div>

                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">
                                            <a href="{{ route('admin.settings', 'license') }}" class="text-dark text-decoration-none d-flex align-items-center">{{ __('License') }} <span class="badge badge-primary {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">{{ config('settings.license_type') ? 'Extended' : 'Regular' }}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-auto d-flex flex-row-reverse align-items-center"></div>
            </div>
        </div>
    </div>
</div>