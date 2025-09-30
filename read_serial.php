<?php
header('Content-Type: application/json');

$logFile = "arduino_log.txt";
$response = [];

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lastLine = trim(end($lines));

    if (preg_match('/^(.*?)\s*-\s*(.*)$/', $lastLine, $matches)) {
        $response['timestamp'] = trim($matches[1]);
        $response['status'] = trim($matches[2]);
    } else {
        $response['timestamp'] = "";
        $response['status'] = $lastLine;
    }
} else {
    $response['timestamp'] = "";
    $response['status'] = "Log file not found! Make sure Python logger is running.";
}

echo json_encode($response);
?>
