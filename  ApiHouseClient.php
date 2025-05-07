<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;

    public function __construct(string $apiUrl) {
        $this->apiUrl = $apiUrl;
        $this->client = new Client(); 
    }

    public function getTotalHouses(): int {
       
        
    }

    public function getAllHouses(): array {
        
    }
}