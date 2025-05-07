<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;

    public function __construct() {
        $this->apiUrl = ''; //get_wp_meta('')
        $this->client = new Client(); 
    }

    public function getTotalHouses(): int {
       
        
    }

    public function getAllHouses(): array {
        
    }
}