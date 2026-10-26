<?php
// api/save_customer.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$billTo = $data['billTo'] ?? '';
$shipTo = $data['shipTo'] ?? '';

if ($name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Customer name is required.']);
    exit;
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'That email address looks invalid.']);
    exit;
}

$stmt = $pdo->prepare('INSERT INTO customers (user_id, name, email, bill_to, ship_to, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
$stmt->execute([$_SESSION['user_id'], $name, $email !== '' ? $email : null, $billTo, $shipTo]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);