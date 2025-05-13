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


require_once REH_PLUGIN_DIR . 'vendor/autoload.php';

require_once REH_PLUGIN_DIR . '/core/cpt/cpt-houses.php';
require_once REH_PLUGIN_DIR . '/core/acf-meta/houses-acf.php';

require_once REH_PLUGIN_DIR . '/core/ApiHouseClient.php';
require_once REH_PLUGIN_DIR . '/core/ParseRunner.php';
require_once REH_PLUGIN_DIR . '/admin/real-estate-page.php';
require_once REH_PLUGIN_DIR . '/core/ajax/ajax-manual-parse.php';


require_once REH_PLUGIN_DIR . '/core/cron/log-cleaner-cron.php';
require_once REH_PLUGIN_DIR . '/core/cron/houses-cron.php';


