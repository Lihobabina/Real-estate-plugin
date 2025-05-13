<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
    private string $housesTotalUrl = 'website/filterCount/';
    private string $allHousesUrl = 'website/filterCount/';

    public function __construct(string $apiUrl) {
        $this->apiUrl = $apiUrl;
        $this->client = new Client(); 
    }

    public function getTotalHouses(): int {
        $url = $this->apiUrl . $this->housesTotalUrl;
        
        try {
            $response = $this->client->request('GET', $url);
            $body = $response->getBody();
            reh_write_log('API Response (getTotalHouses): ' . trim($body));
            $data = json_decode($body, true);
    
            error_log('Total Houses Response: ' . print_r($data, true));
    
            return isset($data['total']) ? (int) $data['total'] : 0;
        } catch (RequestException $e) {
            error_log('Error fetching total houses: ' . $e->getMessage());
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
            if (isset($data['data']) && is_array($data['data'])) {
                return $data['data'];
            } else {
                reh_write_log('Error: Unexpected structure in API response (getAllHouses): ' . print_r($data, true));
                return [];
            }
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
