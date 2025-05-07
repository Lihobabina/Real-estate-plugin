<?php

if (!defined('ABSPATH')) {
    exit;
}

class ParseRunner {


    public function __construct() {

    }
    public function run() {
        if (function_exists('reh_write_log')) {
            reh_write_log('Manual run started via AJAX.');
        }
    }
    

    
}
