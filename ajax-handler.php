<?php

add_action('wp_ajax_reh_run_parser', 'reh_run_parser_ajax');

function reh_run_parser_ajax() {
    check_ajax_referer('reh_run_parser_nonce', 'nonce');

    if (class_exists('ParseRunner')) {
        $parser = new ParseRunner();
        $parser->run();

        wp_send_json_success('Parser finished successfully.');
    } else {
        wp_send_json_error('Parser class not found.');
    }
}
