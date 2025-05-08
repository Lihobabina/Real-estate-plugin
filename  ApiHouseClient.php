<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
    private string $housesTotalUrl = 'website/filterCount/';
    private string $allHousesUrl = 'website/filterCount/';



    public function __construct() {
        $this->apiUrl = ''; 
        $this->client = new Client(); 
    }

    public function getTotalHouses(): int {
       $url = $this->apiUrl . $this->housesTotalUrl;
       
    
    }

    public function getAllHouses(): array {
        
    }
}