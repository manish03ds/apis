<?php
require('database.php');

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id']) || empty($data['paid'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing fields"
    ]);
    exit;
}

$id = $data['id'];
$newPaid = $data['paid'];

$stmt = $pdo->prepare("SELECT estimate, paid FROM customers WHERE id=?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode([
        "success" => false,
        "message" => "Customer not found"
    ]);
    exit;
}

$estimate = $customer['estimate'];
$currentPaid = $customer['paid'];

$paid = $currentPaid + $newPaid;
$balance = $estimate - $paid;

$status = $balance <= 0 ? "completed" : "pending";

$stmt = $pdo->prepare("
UPDATE customers 
SET paid=?, balance=?, status=? 
WHERE id=?
");

$success = $stmt->execute([
    $paid,
    $balance,
    $status,
    $id
]);

echo json_encode([
    "success" => $success
]);
