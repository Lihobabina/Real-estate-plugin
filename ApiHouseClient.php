<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
    private string $housesTotalUrl = 'website/filterCount';
    private string $allHousesUrl = 'website/';

    public function __construct() {
        $this->apiUrl = get_option('reh_basic_url', '');
        if (empty($this->apiUrl)) {
            $errorMessage = 'Error: Basic API URL is not set in the plugin settings.';
            reh_write_log($errorMessage);
            $this->apiUrl = null;
        }
        $this->client = new Client();
    }

    public function getTotalHouses(): array {
        if (empty($this->apiUrl)) {
            return ['success' => false, 'data' => null, 'error' => 'API URL is not configured.'];
        }
        $url = $this->apiUrl . $this->housesTotalUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                reh_write_log('API Response (getTotalHouses): ' . trim($body));
                return ['success' => true, 'data' => (int) trim($body), 'error' => null];
            } else {
                $errorMessage = 'Failed to get total houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody();
                reh_write_log('Error: ' . $errorMessage);
                return ['success' => false, 'data' => null, 'error' => $errorMessage];
            }
        } catch (GuzzleException $e) {
            $errorMessage = 'Guzzle error while getting total houses: ' . $e->getMessage();
            reh_write_log('Error: ' . $errorMessage);
            return ['success' => false, 'data' => null, 'error' => $errorMessage];
        }
    }

    public function getAllHouses(): array {
        if (empty($this->apiUrl)) {
            return ['success' => false, 'data' => null, 'error' => 'API URL is not configured.'];
        }
        $url = $this->apiUrl . $this->allHousesUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                reh_write_log('API Response (getAllHouses): ' . print_r($data, true));
                return ['success' => true, 'data' => $data, 'error' => null];
            } else {
                $errorMessage = 'Failed to get all houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody();
                reh_write_log('Error: ' . $errorMessage);
                return ['success' => false, 'data' => null, 'error' => $errorMessage];
            }
        } catch (GuzzleException $e) {
            $errorMessage = 'Guzzle error while getting all houses: ' . $e->getMessage();
            reh_write_log('Error: ' . $errorMessage);
            return ['success' => false, 'data' => null, 'error' => $errorMessage];
        }
    }
}