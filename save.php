<?php

header("Content-Type: application/json");

require('database.php');

// read JSON input from Flutter
$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'] ?? null;
$name = $data['name'] ?? null;
$address = $data['address'] ?? null;

if (!$user_id || !$name || !$address) {

    echo json_encode([
        "status" => "error",
        "message" => "Missing fields"
    ]);
    exit;
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO workshop (user_id,name,address)
        VALUES (:user_id,:name,:address)
        ON DUPLICATE KEY UPDATE
        name=:name,
        address=:address
    ");

    $stmt->execute([
        ":user_id" => $user_id,
        ":name" => $name,
        ":address" => $address
    ]);

    echo json_encode([
        "status" => "success"
    ]);

} catch(PDOException $e){

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
