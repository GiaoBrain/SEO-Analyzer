@if(request()->is('projects') || request()->is('dashboard'))
    <a href="#" class="btn d-flex align-items-center btn-sm text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</a>
@endif

<div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow">
    <a class="dropdown-item d-flex align-items-center" href="{{ route('reports', ['project' => request()->input('project') ?? $project->project]) }}">@include('icons.list-alt', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Reports') }}</a>

    <div class="dropdown-divider"></div>

    <a class="dropdown-item text-danger d-flex align-items-center" href="#" data-toggle="modal" data-target="#modal" data-action="{{ route('projects.destroy', request()->input('project') ?? $project->project) }}" data-button="btn btn-danger" data-title="{{ __('Delete') }}" data-text="{{ __('Deleting this project is permanent, and will remove all the reports associated with it.') }}" data-sub-text="{{ __('Are you sure you want to delete :name?', ['name' => request()->input('project') ?? $project->project]) }}">@include('icons.delete', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Delete') }}</a>
</div>