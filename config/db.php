<?php
// config/db.php
$host = 'localhost';
$dbname = 'u160541212_invoice_gendb';
$username = 'u160541212_invoice_user';
$password = '2+VQUILS*pE'; // default XAMPP MySQL password is empty

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
