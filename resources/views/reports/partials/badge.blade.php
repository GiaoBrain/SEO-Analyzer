<a href="{{ route('reports.show', $report->id) }}" class="d-none d-md-inline-block badge {{ ($report->result > 79 ? 'badge-success' : ($report->result > 49 ? 'badge-warning' : 'badge-danger')) }} text-truncate" data-enable="tooltip" data-html="true" title='
<div class="mx-2 font-size-base">
    <div class="d-flex text-truncate align-items-center my-2">
        @include('icons.triangle', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->highIssuesCount > 0 ? 'text-danger ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

        <div class="text-truncate">
            {{ __(($report->highIssuesCount == 1 ? ':value high issue' : ':value high issues'), ['value' => number_format($report->highIssuesCount, 0, __('.'), __(','))]) }}
        </div>
    </div>

    <div class="d-flex text-truncate align-items-center my-2">
        @include('icons.square', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->mediumIssuesCount > 0 ? 'text-warning ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

        <div class="text-truncate">
            {{ __(($report->mediumIssuesCount == 1 ? ':value medium issue' : ':value medium issues'), ['value' => number_format($report->mediumIssuesCount, 0, __('.'), __(','))]) }}
        </div>
    </div>

    <div class="d-flex text-truncate align-items-center my-2">
        @include('icons.circle', ['class' => 'flex-shrink-0 width-3 height-3 fill-current ' . ($report->lowIssuesCount > 0 ? 'text-secondary ' : 'text-success ') . (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2')])

        <div class="text-truncate">
            {{ __(($report->lowIssuesCount == 1 ? ':value low issue' : ':value low issues'), ['value' => number_format($report->lowIssuesCount, 0, __('.'), __(','))]) }}
        </div>
    </div>
</div>
'>
    {{ ($report->result > 79 ? __('Good') : ($report->result > 49 ? __('Decent') : __('Bad'))) }}
</a>