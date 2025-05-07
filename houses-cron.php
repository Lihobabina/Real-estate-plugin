<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('reh_cron_hook', 'reh_run_scheduled_task');

function reh_run_scheduled_task() {
    //#TODO
}


if (!wp_next_scheduled('reh_cron_hook')) {
    wp_schedule_event(time(), 'hourly', 'reh_cron_hook');
}
