<?php
header('Content-Type: application/json');

$logFile = "arduino_log.txt";
$response = [];

if (file_exists($logFile)) {
    // Read all lines and remove empty lines
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lastLine = trim(end($lines));

    // Split by the first " - " into timestamp and status
    $parts = explode(" - ", $lastLine, 2);

    if (count($parts) === 2) {
        $timestamp = trim($parts[0]);
        $status = trim($parts[1]);

        // Normalize status to capitalize first letter (Offline / Online)
        $status = ucfirst(strtolower($status));

        $response['timestamp'] = $timestamp;
        $response['status'] = $status;
    } else {
        // If line doesn't have " - ", put entire line as status
        $response['timestamp'] = "";
        $response['status'] = ucfirst(strtolower($lastLine));
    }
} else {
    $response['timestamp'] = "";
    $response['status'] = "Log file not found! Make sure Python logger is running.";
}

// Output JSON
echo json_encode($response);
?>
