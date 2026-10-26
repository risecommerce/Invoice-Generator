<?php
// api/mark_paid.php
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

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing invoice id.']);
    exit;
}

$stmt = $pdo->prepare('UPDATE invoices SET status = ? WHERE id = ? AND user_id = ?');
$stmt->execute(['Paid', $id, $_SESSION['user_id']]);

echo json_encode(['success' => true]);
