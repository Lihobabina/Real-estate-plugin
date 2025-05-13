<?php

if (!defined('ABSPATH')) {
    exit;
}

class ParseRunner {
    private ApiHouseClient $apiHouseClient;

    public function __construct() {
        $this->apiHouseClient = new ApiHouseClient();
    }

    public function run() {
        
        $totalHousesResult = $this->apiHouseClient->getTotalHouses();
        $allHousesResult = $this->apiHouseClient->getAllHouses();

        return ['success' => true, 'message' => 'Data fetched from API and appended to log. Total houses: ' . ($totalHousesResult['success'] ? $totalHousesResult['data'] : 'error')];
    }

   
}