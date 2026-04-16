<?php
require('database.php');

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (
    empty($data['id']) ||
    empty($data['user_id'])
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing fields"
    ]);
    exit;
}

$id = $data['id'];
$user_id = $data['user_id'];

$stmt = $pdo->prepare("
DELETE FROM customers 
WHERE id=? AND user_id=?
");

$success = $stmt->execute([$id, $user_id]);

echo json_encode([
    "success" => $success
]);
