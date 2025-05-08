<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
    private string $housesTotalUrl = 'website/filterCount/';
    private string $allHousesUrl = 'website/';

    public function __construct() {
        $this->apiUrl = get_option('reh_basic_url', '');
        if (empty($this->apiUrl)) {
            reh_write_log('Error: Basic API URL is not set in the plugin settings.');
        }
        $this->client = new Client();
    }

    public function getTotalHouses(): int {
        if (empty($this->apiUrl)) return 0;
        $url = $this->apiUrl . $this->housesTotalUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                reh_write_log('API Response (getTotalHouses): ' . trim($body));
                $total = (int) trim($body);
                return $total;
            } else {
                reh_write_log('Error: Failed to get total houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody());
                return 0;
            }
        } catch (GuzzleException $e) {
            reh_write_log('Error: Guzzle error while getting total houses: ' . $e->getMessage());
            return 0;
        }
    }

    public function getAllHouses(): array {
        if (empty($this->apiUrl)) return [];
        $url = $this->apiUrl . $this->allHousesUrl;
        try {
            $response = $this->client->request('GET', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                reh_write_log('API Response (getAllHouses): ' . print_r($data, true)); 
                return $data;
            } else {
                reh_write_log('Error: Failed to get all houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody());
                return [];
            }
        } catch (GuzzleException $e) {
            reh_write_log('Error: Guzzle error while getting all houses: ' . $e->getMessage());
            return [];
        }
    }
}
