<?php
// api/get_send_quota.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

$limit = 105; // Free plan monthly limit - adjust here if you introduce paid plans later

$stmt = $pdo->prepare(
    "SELECT COUNT(*) AS c FROM invoice_sends WHERE user_id = ? AND sent_at >= DATE_FORMAT(NOW(), '%Y-%m-01')"
);
$stmt->execute([$_SESSION['user_id']]);
$used = (int)$stmt->fetch()['c'];

echo json_encode(['limit' => $limit, 'used' => $used, 'remaining' => max(0, $limit - $used)]);
