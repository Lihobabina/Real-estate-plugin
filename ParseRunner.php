<?php

if (!defined('ABSPATH')) {
    exit;
}

class ParseRunner {
    private ApiHouseClient $apiHouseClient;

    public function __construct() {
        $this->apiHouseClient = new ApiHouseClient();
    }

    public function run() {
            reh_write_log('Manual run started via AJAX.');

        $totalHousesResult = $this->apiHouseClient->getTotalHouses();
            if ($totalHousesResult['success']) {
                reh_write_log('Total houses: ' . $totalHousesResult['data']);
            } else {
                reh_write_log('Error getting total houses: ' . $totalHousesResult['error']);
            }

        $allHousesResult = $this->apiHouseClient->getAllHouses();
        $this->logAllHousesData($allHousesResult);

        return ['success' => true, 'message' => 'Data fetched from API and appended to log. Total houses: ' . ($totalHousesResult['success'] ? $totalHousesResult['data'] : 'error')];
    }

    private function logAllHousesData(array $allHousesResult): void {
            $logMessage = "--- All Houses Data ---\n";
            $logMessage .= print_r($allHousesResult, true);
            $logMessage .= "\n--- End of Data ---\n";

            $logFilePath = REH_PLUGIN_DIR . '/log.txt';
            file_put_contents($logFilePath, $logMessage, FILE_APPEND);

            $currentLogContent = file_get_contents($logFilePath);
            update_option('reh_log_output', $currentLogContent);
    }
}