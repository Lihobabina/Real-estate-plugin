<?php
<<<<<<< HEAD

=======
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiHouseClient {
    private string $apiUrl;
    private Client $client;
<<<<<<< HEAD
    private string $housesTotalUrl = 'website/filterCount';
=======
    private string $housesTotalUrl = 'website/filterCount/';
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
    private string $allHousesUrl = 'website/';

    public function __construct() {
        $this->apiUrl = get_option('reh_basic_url', '');
        if (empty($this->apiUrl)) {
<<<<<<< HEAD
            $errorMessage = 'Error: Basic API URL is not set in the plugin settings.';
            reh_write_log($errorMessage);
            $this->apiUrl = null;
=======
            reh_write_log('Error: Basic API URL is not set in the plugin settings.');
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
        }
        $this->client = new Client();
    }

<<<<<<< HEAD
    public function getTotalHouses(): array {
        if (empty($this->apiUrl)) {
            return ['success' => false, 'data' => null, 'error' => 'API URL is not configured.'];
        }
=======
    public function getTotalHouses(): int {
        if (empty($this->apiUrl)) return 0;
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
        $url = $this->apiUrl . $this->housesTotalUrl;
        try {
            $response = $this->client->request('POST', $url);
            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                reh_write_log('API Response (getTotalHouses): ' . trim($body));
<<<<<<< HEAD
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
=======
                $total = (int) trim($body);
                return $total;
            } else {
                reh_write_log('Error: Failed to get total houses. Status code: ' . $response->getStatusCode() . '. Response body: ' . $response->getBody());
                return 0;
            }
        } catch (GuzzleException $e) {
            reh_write_log('Error: Guzzle error while getting total houses: ' . $e->getMessage());
            return 0;
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
        }
    }

    public function getAllHouses(): array {
<<<<<<< HEAD
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
=======
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
>>>>>>> 659b82170ca58c1691f917f1957501b519744416
