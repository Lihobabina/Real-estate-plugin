<?php
/**
 * Plugin Name: Real Estate Houses
 * Version: 1.0
 * Text Domain: real-estate-houses
 */

if (!defined('ABSPATH')) {
    exit;
}

define('REH_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!class_exists('ACF')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p><strong>Real Estate Houses</strong> requires the <strong>Advanced Custom Fields</strong> plugin to be active.</p></div>';
    });
    return;
}

require_once REH_PLUGIN_DIR . '/cpt-houses.php';
require_once REH_PLUGIN_DIR . '/admin/real-estate-page.php';
require_once REH_PLUGIN_DIR . '/houses-cron.php';
require_once REH_PLUGIN_DIR . '/ParseRunner.php';
require_once REH_PLUGIN_DIR . '/ajax-handler.php';
require_once REH_PLUGIN_DIR . '/log-cleaner-cron.php';

