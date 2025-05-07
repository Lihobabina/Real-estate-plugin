<?php

if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title'    => 'Real Estate Settings',
        'menu_title'    => 'Real Estate',
        'menu_slug'     => 'real-estate-settings',
        'capability'    => 'manage_options',
        'redirect'      => false
    ]);
}

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_real_estate_settings',
        'title' => 'Real Estate Settings',
        'fields' => [
            [
                'key' => 'field_tab_api',
                'label' => 'API',
                'type' => 'tab',
                'placement' => 'top'
            ],
            [
                'key' => 'field_api_key',
                'label' => 'API',
                'name' => 'api_key',
                'type' => 'text'
            ],
            [
                'key' => 'field_tab_manual_run',
                'label' => 'Manual Run',
                'type' => 'tab',
                'placement' => 'top'
            ],
            [
                'key' => 'field_manual_button',
                'label' => 'Run Import',
                'name' => 'manual_button',
                'type' => 'button_group', 
                'choices' => [
                    'run' => 'Run Import' 
                ],
                'default_value' => '',
            ],
            [
                'key' => 'field_tab_log',
                'label' => 'Log',
                'type' => 'tab',
                'placement' => 'top'
            ],
            [
                'key' => 'field_log_output',
                'label' => 'Log Output',
                'name' => 'log_output',
                'type' => 'textarea',
                'readonly' => 1
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'real-estate-settings'
                ]
            ]
        ]
    ]);
}
