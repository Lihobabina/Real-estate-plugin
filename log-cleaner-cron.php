<?php
if (!defined('ABSPATH')) {
    exit;
}

function reh_clear_log_file() {
    $log_file = plugin_dir_path(__FILE__) . 'log.txt';
    if (file_exists($log_file)) {
        file_put_contents($log_file, '');
    }
}

add_action('reh_clear_log', 'reh_clear_log_file');

function reh_schedule_log_cleaning() {
    if (!wp_next_scheduled('reh_clear_log')) {
        wp_schedule_event(time(), 'daily', 'reh_clear_log');
    }
}
add_action('wp', 'reh_schedule_log_cleaning');

function reh_clear_log_deactivation() {
    $timestamp = wp_next_scheduled('reh_clear_log');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'reh_clear_log');
    }
}
register_deactivation_hook(__FILE__, 'reh_clear_log_deactivation');
