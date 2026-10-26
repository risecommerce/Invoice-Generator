<?php

header('Content-Type: application/json');

$ip = $_SERVER['REMOTE_ADDR'] ?? '';

$url = 'http://ip-api.com/php/' . urlencode($ip)
     . '?fields=status,country,countryCode,currency';

$response = @file_get_contents($url);

if ($response === false) {
    echo json_encode([
        'status' => 'fail',
        'message' => 'Unable to connect to IP API',
        'ip' => $ip
    ]);
    exit;
}

$data = @unserialize($response);

if (!is_array($data)) {
    echo json_encode([
        'status' => 'fail',
        'message' => 'Invalid API response',
        'ip' => $ip
    ]);
    exit;
}

echo json_encode([
    'status'      => $data['status'] ?? 'fail',
    'ip'          => $ip,
    'country'     => $data['country'] ?? null,
    'countryCode' => $data['countryCode'] ?? null,
    'currency'    => $data['currency'] ?? null
]);