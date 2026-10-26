<?php
// api/update_customer.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = (int)($data['id'] ?? 0);
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$billTo = $data['billTo'] ?? '';
$shipTo = $data['shipTo'] ?? '';

if (!$id || $name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Customer id and name are required.']);
    exit;
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'That email address looks invalid.']);
    exit;
}

$stmt = $pdo->prepare('UPDATE customers SET name = ?, email = ?, bill_to = ?, ship_to = ? WHERE id = ? AND user_id = ?');
$stmt->execute([$name, $email !== '' ? $email : null, $billTo, $shipTo, $id, $_SESSION['user_id']]);

echo json_encode(['success' => true]);
