<?php

if (!defined('ABSPATH')) {
    exit;
}

class ParseRunner {
    private $apiHouseClient;

    public function __construct() {
        $apiUrl = get_option('reh_basic_url');
        $this->apiHouseClient = new ApiHouseClient($apiUrl);
    }

public function run($offset = 0) {
    $limit = (int) get_option('reh_per_run_limit'); 
    reh_write_log("ParseRunner initiated. Offset: {$offset}, Limit: {$limit}");

    $totalResult = $this->apiHouseClient->getTotalHouses();

    if (!$totalResult['success']) {
        reh_write_log("Error getting total houses: " . $totalResult['error']);
        return [
            'success' => false,
            'message' => 'Failed to get total houses: ' . $totalResult['error']
        ];
    }

    $total = $totalResult['data'];
    reh_write_log("Total houses found: {$total}");

    if ($offset >= $total) {
        reh_write_log("Import complete. All houses processed (offset {$offset} >= total {$total}).");
        return [
            'success' => true,
            'message' => 'Import complete. All houses processed.'
        ];
    }

    $page = (int) floor($offset / $limit) + 1;

    $batchResult = $this->apiHouseClient->getHousesBatch($page, $limit);

    if (!$batchResult['success']) {
        reh_write_log("Error getting houses batch: " . $batchResult['error']);
        return [
            'success' => false,
            'message' => 'Failed to get houses batch: ' . $batchResult['error']
        ];
    }

    $houses = $batchResult['data']['data'] ?? [];
    $processed = count($houses);
    reh_write_log("Requested limit: {$limit}, Actual houses received: {$processed}");

    $next_offset = $offset + $processed;

    reh_write_log("Processed {$processed} houses. Next offset: {$next_offset}. Total: {$total}");

    return [
        'success' => true,
        'message' => "Processed {$processed} houses (from {$offset} to " . ($offset + $processed - 1) . ")",
        'next_offset' => $next_offset,
        'total' => $total
    ];
}

}