<?php

require('database.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (
    empty($data['userId']) ||
    empty($data['name']) ||
    empty($data['phone']) ||
    empty($data['vehicleNumber'])
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

try {

$user_id = (int)$data['userId'];
$name = $data['name'];
$phone = $data['phone'];
$email = $data['email'] ?? null;

$vehicle_number = $data['vehicleNumber'];
$vehicle_model = $data['vehicleModel'] ?? null;
$vehicle_type = $data['vehicleType'] ?? null;
$problem_description = $data['problemDescription'] ?? null;

$estimate = isset($data['estimate']) ? (float)$data['estimate'] : 0;
$paid = isset($data['paid']) ? (float)$data['paid'] : 0;
$balance = isset($data['balance']) ? (float)$data['balance'] : 0;

$status = $data['status'] ?? "pending";

$stmt = $pdo->prepare("
INSERT INTO customers
(user_id,name,phone,email,vehicle_number,vehicle_model,vehicle_type,problem_description,estimate,paid,balance,status)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->execute([
    $user_id,
    $name,
    $phone,
    $email,
    $vehicle_number,
    $vehicle_model,
    $vehicle_type,
    $problem_description,
    $estimate,
    $paid,
    $balance,
    $status
]);

echo json_encode([
    "success" => true,
    "message" => "Customer added successfully"
]);

} catch (PDOException $e) {

echo json_encode([
    "success" => false,
    "message" => $e->getMessage()
]);

}
