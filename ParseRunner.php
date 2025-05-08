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
        if (function_exists('reh_write_log')) {
            reh_write_log('Manual run started via AJAX.');
        }

        $totalHouses = $this->apiHouseClient->getTotalHouses();
        if (function_exists('reh_write_log')) {
            reh_write_log('Total houses: ' . $totalHouses);
        }

        $allHousesData = $this->apiHouseClient->getAllHouses();

        $logMessage = "--- All Houses Data ---\n";
        $logMessage .= print_r($allHousesData, true);
        $logMessage .= "\n--- End of Data ---\n";

        $logFilePath = REH_PLUGIN_DIR . '/log.txt';
        file_put_contents($logFilePath, $logMessage, FILE_APPEND);

        $currentLogContent = file_get_contents($logFilePath);
        update_option('reh_log_output', $currentLogContent);

        return ['success' => true, 'message' => 'Data fetched from API and appended to log. Total houses: ' . $totalHouses];
    }
}