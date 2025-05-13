<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
    private string $housesTotalUrl = 'website/filterCount';
    private string $allHousesUrl = 'website/';

    public function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
        $this->client = new Client();
    }

    public function getTotalHouses(): array {
        $url = $this->apiUrl . $this->housesTotalUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                return ['success' => true, 'data' => (int) trim($body), 'error' => null];
            } else {
                $errorMessage = 'Failed to get total houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody();
                return ['success' => false, 'data' => null, 'error' => $errorMessage];
            }
        } catch (GuzzleException $e) {
            $errorMessage = 'Guzzle error while getting total houses: ' . $e->getMessage();
            return ['success' => false, 'data' => null, 'error' => $errorMessage];
        }
    }

    public function getAllHouses(): array {
        $url = $this->apiUrl . $this->allHousesUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                return ['success' => true, 'data' => $data, 'error' => null];
            } else {
                $errorMessage = 'Failed to get all houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody();
                return ['success' => false, 'data' => null, 'error' => $errorMessage];
            }
        } catch (GuzzleException $e) {
            $errorMessage = 'Guzzle error while getting all houses: ' . $e->getMessage();
            return ['success' => false, 'data' => null, 'error' => $errorMessage];
        }
    }
}