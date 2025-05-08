<?php

if (!defined('ABSPATH')) {
    exit;
}

class ParseRunner {
    private ApiHouseClient $apiHouseClient;

    public function __construct() {
        $this->apiHouseClient = new ApiHouseClient();

    }

    public function start(){
        $totalHouses = $this->apiHouseClient->getTotalHouses();
        


    }
    public function run() {
        if (function_exists('reh_write_log')) {
            reh_write_log('Manual run started via AJAX.');
        }
    }
    

    
}
