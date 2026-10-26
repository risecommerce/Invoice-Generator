<?php
// signin.php
require 'includes/auth.php';
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signin');
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: signin?error=1');
    exit;
}

$_SESSION['user_id']    = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name']  = $user['last_name'];
$_SESSION['email']      = $user['email'];

// "Keep me logged in" -> extend the session cookie lifetime to 30 days
if (isset($_POST['keepLoggedIn'])) {
    $params = session_get_cookie_params();
    setcookie(session_name(), session_id(), time() + 60 * 60 * 24 * 30, $params['path']);
}

header('Location: dashboard');
exit;
