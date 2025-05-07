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

    

    
}
