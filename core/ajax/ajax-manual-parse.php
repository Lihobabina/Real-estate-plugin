<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_reh_run_parser', 'reh_run_parser_ajax');

function reh_run_parser_ajax() {
    if ( ! check_ajax_referer( 'reh_run_parser_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Nonce verification failed.' );
        wp_die();
    }

    $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;

    if (class_exists('ParseRunner')) {
        $parser = new ParseRunner();
        $result = $parser->run($offset);

        if ($result['success']) {
            wp_send_json_success([
                'message' => $result['message'],
                'next_offset' => isset($result['next_offset']) ? $result['next_offset'] : null,
                'total' => isset($result['total']) ? $result['total'] : null,
                'done' => !isset($result['next_offset']) || $result['next_offset'] >= $result['total'] 
            ]);
        } else {
            wp_send_json_error($result['message']);
        }
    } else {
        wp_send_json_error('Parser class not found.');
    }

    wp_die();
}