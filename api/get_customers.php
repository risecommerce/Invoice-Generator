<?php
// api/get_customers.php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];

// active or deleted
$view = isset($_GET['view']) && $_GET['view'] === 'deleted'
    ? 'deleted'
    : 'active';

if ($view === 'deleted') {
    $whereDeleted = 'AND deleted_at IS NOT NULL';
} else {
    $whereDeleted = 'AND deleted_at IS NULL';
}

try {

    $sql = "
        SELECT
            id,
            user_id,
            name,
            email,
            bill_to,
            ship_to,
            created_at,
            deleted_at
        FROM customers
        WHERE user_id = ?
        $whereDeleted
        ORDER BY created_at DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $customers = [];

    foreach ($rows as $row) {
        $customers[] = [
            'id' => (int)$row['id'],
            'user_id' => (int)$row['user_id'],
            'name' => $row['name'] ?? '',
            'email' => $row['email'] ?? '',
            'bill_to' => $row['bill_to'] ?? '',
            'ship_to' => $row['ship_to'] ?? '',
            'createdAt' => $row['created_at'] ?? '',
            'deletedAt' => $row['deleted_at'] ?? null
        ];
    }

    echo json_encode([
        'customers' => $customers
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'error' => 'Failed to load customers.',
        'details' => $e->getMessage()
    ]);
}