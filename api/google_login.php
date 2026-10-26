<?php
// api/google_login.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$credential = $data['credential'] ?? '';

if (!$credential) {
    http_response_code(400);
    echo json_encode(['error' => 'No credential provided.']);
    exit;
}

// Verify the ID token with Google's API
// For production, it's better to use Google API Client Library for PHP
$url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $credential;
$response = file_get_contents($url);
$payload = json_decode($response, true);

if (!$payload || isset($payload['error_description'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ID token.']);
    exit;
}

// Check if the audience (aud) matches your Client ID
// $google_client_id = "YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com";
// if ($payload['aud'] !== $google_client_id) { ... }

$google_id = $payload['sub'];
$email = $payload['email'];
$first_name = $payload['given_name'] ?? '';
$last_name = $payload['family_name'] ?? '';
$picture = $payload['picture'] ?? '';

// Check if user exists by google_id or email
$stmt = $pdo->prepare('SELECT * FROM users WHERE google_id = ? OR email = ?');
$stmt->execute([$google_id, $email]);
$user = $stmt->fetch();

if ($user) {
    // Update google_id if it was found by email but google_id was null
    if (!$user['google_id']) {
        $stmt = $pdo->prepare('UPDATE users SET google_id = ? WHERE id = ?');
        $stmt->execute([$google_id, $user['id']]);
    }
} else {
    // Create new user
    $stmt = $pdo->prepare(
        'INSERT INTO users (first_name, last_name, email, google_id, country) VALUES (?, ?, ?, ?, ?)'
    );
    // Use 'Other' or a default country for social signup
    $stmt->execute([$first_name, $last_name, $email, $google_id, 'Other']);
    
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$pdo->lastInsertId()]);
    $user = $stmt->fetch();
}

// Start session
$_SESSION['user_id']    = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name']  = $user['last_name'];
$_SESSION['email']      = $user['email'];

echo json_encode(['success' => true]);
