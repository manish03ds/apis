<?php

$host = "sql.infinityfree.com";
$db   = "your_database_name";
$user = "your_database_user";
$pass = "your_database_password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}

?>