<?php

require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);

$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode([
        "success" => false,
        "message" => "Customer not found"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "customer" => $customer
]);