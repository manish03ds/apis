<?php

require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

$userId = $_GET['user_id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM customers WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$userId]);

$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "customers" => $customers
]);