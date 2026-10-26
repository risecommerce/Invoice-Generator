<?php
// signup.php
require 'includes/auth.php';
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup');
    exit;
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName  = trim($_POST['lastName'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$country   = trim($_POST['country'] ?? '');

$errors = [];

if ($firstName === '' || $lastName === '') $errors[] = 'First and last name are required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
if ($country === '') $errors[] = 'Please select a country.';

if (empty($errors)) {
    // Check if email already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'An account with that email already exists.';
    }
}

if (!empty($errors)) {
    // Send the user back to the signup page with the error shown
    $_SESSION['signup_errors'] = $errors;
    header('Location: signup?error=1');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    'INSERT INTO users (first_name, last_name, email, password_hash, country) VALUES (?, ?, ?, ?, ?)'
);
$stmt->execute([$firstName, $lastName, $email, $passwordHash, $country]);

$userId = $pdo->lastInsertId();

// Log the new user in immediately
$_SESSION['user_id']    = $userId;
$_SESSION['first_name'] = $firstName;
$_SESSION['last_name']  = $lastName;
$_SESSION['email']      = $email;

header('Location: dashboard');
exit;
