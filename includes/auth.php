<?php
// includes/auth.php
// Include this at the top of any page/API that needs to know who is logged in.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function currentUser() {
    if (!isLoggedIn()) return null;
    return [
        'id'         => $_SESSION['user_id'],
        'first_name' => $_SESSION['first_name'] ?? '',
        'last_name'  => $_SESSION['last_name'] ?? '',
        'email'      => $_SESSION['email'] ?? '',
    ];
}

// Redirects guests away from pages that require login (e.g. dashboard.php)
function requireLogin($redirectTo = 'signin') {
    if (!isLoggedIn()) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

// Small helper to build initials for the avatar circle, e.g. "Charak Dev" -> "CD"
function userInitials($first, $last) {
    $f = trim($first) !== '' ? mb_substr(trim($first), 0, 1) : '';
    $l = trim($last)  !== '' ? mb_substr(trim($last), 0, 1) : '';
    $initials = strtoupper($f . $l);
    return $initials !== '' ? $initials : 'U';
}
