<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = 'http://fastreport-service:80/api/reports/generate';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Handle redirects if any
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);

    if ($httpCode === 200 && strpos($contentType, 'application/pdf') !== false) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="report.pdf"');
        header('Content-Length: ' . strlen($response));
        echo $response;
        exit;
    } else {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to generate report', 'response' => $response]);
        exit;
    }
}
?>