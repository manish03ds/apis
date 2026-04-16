<?php

header('Content-Type: application/json');

require('database.php');
require '../utils/response.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$phone = $data['phone'] ?? '';

if(!$name || !$email || !$password){
    sendResponse(false,"Missing fields");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

try{

$stmt = $pdo->prepare("INSERT INTO users(name,email,password,phone) VALUES(?,?,?,?)");

$stmt->execute([
    $name,
    $email,
    $hashed,
    $phone
]);

sendResponse(true,"User Registered");

}catch(PDOException $e){

sendResponse(false,"Email already exists");

}

?>
