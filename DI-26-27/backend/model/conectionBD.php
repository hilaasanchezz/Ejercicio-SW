<?php
$host    = 'localhost';
$db      = 'universidad';
$user    = 'root';
$pass    = '1234';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Crea la conexión PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['success' => false, 'msg' => 'Error de conexión: ' . $e->getMessage()]);
    exit;
}