@if(request()->is('admin/*') || request()->is('reports') || request()->is('reports/*/edit') || request()->is('dashboard'))
    <a href="#" class="btn d-flex align-items-center btn-sm text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</a>
@endif

<div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow z-1001">
    @if(request()->is('admin/*') || Auth::check() && Auth::user()->role == 1 || Auth::check() && $report->user_id == Auth::user()->id)
        <a class="dropdown-item d-flex align-items-center" href="{{ request()->is('admin/*') || (Auth::user()->role == 1 && $report->user_id != Auth::user()->id) ? route('admin.reports.edit', $report->id) : route('reports.edit', $report->id) }}">@include('icons.edit', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Edit') }}</a>
    @endif

    <a class="dropdown-item d-flex align-items-center" href="{{ route('reports.show', ['id' => $report->id]) }}">@include('icons.eye', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('View') }}</a>

    <a class="dropdown-item d-flex align-items-center" href="{{ $report->fullUrl }}" target="_blank" rel="nofollow noreferrer noopener">@include('icons.open-in-new', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Open') }}</a>

    @if(request()->is('admin/*') || Auth::check() && Auth::user()->role == 1 || Auth::check() && $report->user_id == Auth::user()->id)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item text-danger d-flex align-items-center" href="#" data-toggle="modal" data-target="#modal" data-action="{{ request()->is('admin/*') || (Auth::user()->role == 1 && $report->user_id != Auth::user()->id) ? route('admin.reports.destroy', $report->id) : route('reports.destroy', ['id' => $report->id, 'project' => request()->input('project')]) }}" data-button="btn btn-danger" data-title="{{ __('Delete') }}" data-text="{{ __('Are you sure you want to delete :name?', ['name' => $report->url]) }}">@include('icons.delete', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Delete') }}</a>
    @endif
</div>