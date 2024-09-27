@php
    $parameters = [
        [
            'name' => 'search',
            'type' => 0,
            'format' => 'string',
            'description' => __('The search query.')
        ], [
            'name' => 'search_by',
            'type' => 0,
            'format' => 'string',
            'description' => __('Search by') . '. ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>url</code>', 'name' => '<span class="font-weight-medium">'.__('URL').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>url</code>'])
        ], [
            'name' => 'project',
            'type' => 0,
            'format' => 'string',
            'description' => __('The project name.')
        ], [
            'name' => 'result',
            'type' => 0,
            'format' => 'string',
            'description' => __('The report result.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>good</code>', 'name' => '<span class="font-weight-medium">'.__('Good').'</span>']),
                    __(':value for :name', ['value' => '<code>decent</code>', 'name' => '<span class="font-weight-medium">'.__('Decent').'</span>']),
                    __(':value for :name', ['value' => '<code>bad</code>', 'name' => '<span class="font-weight-medium">'.__('Bad').'</span>'])])
                ])
        ], [
            'name' => 'sort_by',
            'type' => 0,
            'format' => 'string',
            'description' => __('Sort by') . '. ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>id</code>', 'name' => '<span class="font-weight-medium">'.__('Date created').'</span>']),
                    __(':value for :name', ['value' => '<code>generated_at</code>', 'name' => '<span class="font-weight-medium">'.__('Date generated').'</span>']),
                    __(':value for :name', ['value' => '<code>url</code>', 'name' => '<span class="font-weight-medium">'.__('URL').'</span>']),
                    __(':value for :name', ['value' => '<code>result</code>', 'name' => '<span class="font-weight-medium">'.__('Result').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>id</code>'])
        ], [
            'name' => 'sort',
            'type' => 0,
            'format' => 'string',
            'description' => __('Sort') . '. ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>desc</code>', 'name' => '<span class="font-weight-medium">'.__('Descending').'</span>']),
                    __(':value for :name', ['value' => '<code>asc</code>', 'name' => '<span class="font-weight-medium">'.__('Ascending').'</span>'])
                    ])
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>desc</code>'])
        ], [
            'name' => 'per_page',
            'type' => 0,
            'format' => 'int',
            'description' => __('Results per page') . '. '. __('Possible values are: :values.', [
                'values' => '<code>' . implode('</code>, <code>', [10, 25, 50, 100]) . '</code>'
                ]) .' ' . __('Defaults to: :value.', ['value' => '<code>'.config('settings.paginate').'</code>'])
        ]
    ];
@endphp

@include('developers.parameters')