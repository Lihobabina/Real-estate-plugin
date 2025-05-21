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
                $errorMessage = 'Failed to get total houses. Status code: ' . $response->getStatusCode();
                return ['success' => false, 'data' => null, 'error' => $errorMessage];
            }
        } catch (GuzzleException $e) {
            $errorMessage = 'Guzzle error while getting total houses: ' . $e->getMessage();
            return ['success' => false, 'data' => null, 'error' => $errorMessage];
        }
    }

    public function getHousesBatch(int $page, int $perPage): array {
        $url = $this->apiUrl . $this->allHousesUrl;
        try {
            $response = $this->client->request('POST', $url, [
                'json' => [
                    'page' => $page,
                    'perPage' => $perPage
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return ['success' => false, 'data' => null, 'error' => 'Failed to decode JSON: ' . json_last_error_msg()];
                }
                return ['success' => true, 'data' => $data, 'error' => null];
            } else {
                return ['success' => false, 'data' => null, 'error' => 'Failed to get houses batch. Status code: ' . $response->getStatusCode()];
            }
        } catch (GuzzleException $e) {
            return ['success' => false, 'data' => null, 'error' => 'Guzzle error: ' . $e->getMessage()];
        }
    }
}
