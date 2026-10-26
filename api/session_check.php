<?php
// api/session_check.php
require '../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['loggedIn' => false]);
    exit;
}

$user = currentUser();
echo json_encode([
    'loggedIn'  => true,
    'firstName' => $user['first_name'],
    'lastName'  => $user['last_name'],
    'email'     => $user['email'],
    'initials'  => userInitials($user['first_name'], $user['last_name']),
]);
