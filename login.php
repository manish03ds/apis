<?php

require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

if (
    empty($data['email']) ||
    empty($data['password'])
) {

    echo json_encode([
        "success" => false,
        "message" => "Missing fields"
    ]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

if (!password_verify($password, $user['password'])) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid password"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email']
    ]
]);