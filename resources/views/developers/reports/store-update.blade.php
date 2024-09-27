@php
    if($type) {
        $parameters[] = [
            'name' => 'url',
            'type' => $type,
            'format' => 'string',
            'description' => __('The webpage\'s URL.')
        ];
    }

    $parameters[] = [
        'name' => 'privacy',
        'type' => 0,
        'format' => 'integer',
        'description' => __('Report page privacy.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('Public').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Private').'</span>']),
                    __(':value for :name', ['value' => '<code>2</code>', 'name' => '<span class="font-weight-medium">'.__('Password').'</span>'])
                    ])
                ]) . ($type ? ' ' . __('Defaults to: :value.', ['value' => '<code>1</code>']) : '')
    ];

    $parameters[] = [
        'name' => 'password',
        'type' => 0,
        'format' => 'string',
        'description' => __('The password for the report page.') . ' ' . __('Only works with :field set to :value.', ['field' => '<code>privacy</code>', 'value' => '<code>2</code>'])
    ];

    if(!$type) {
        $parameters[] = [
            'name' => 'results',
            'type' => $type,
            'format' => 'integer',
            'description' => __('Update the report results.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('No').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Yes').'</span>'])
                    ])
                ]) . ' ' . __('Defaults to: :value.', ['value' => '<code>0</code>'])
        ];
    }
@endphp

@include('developers.parameters')