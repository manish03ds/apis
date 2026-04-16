<?php
require('database.php');

header("Content-Type: application/json");

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User ID missing"
    ]);
    exit;
}

try {

    // Weekly income
    $stmt = $pdo->prepare("
        SELECT SUM(paid) as weekly_income
        FROM customers
        WHERE user_id = ?
        AND YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)
    ");
    $stmt->execute([$user_id]);
    $weekly = $stmt->fetchColumn() ?? 0;

    // Monthly income
    $stmt = $pdo->prepare("
        SELECT SUM(paid) as monthly_income
        FROM customers
        WHERE user_id = ?
        AND MONTH(created_at) = MONTH(CURDATE())
        AND YEAR(created_at) = YEAR(CURDATE())
    ");
    $stmt->execute([$user_id]);
    $monthly = $stmt->fetchColumn() ?? 0;

    // Pending balance
    $stmt = $pdo->prepare("
        SELECT SUM(balance) as pending_balance
        FROM customers
        WHERE user_id = ?
        AND status = 'pending'
    ");
    $stmt->execute([$user_id]);
    $pending = $stmt->fetchColumn() ?? 0;

    echo json_encode([
        "success" => true,
        "weekly_income" => $weekly,
        "monthly_income" => $monthly,
        "pending_balance" => $pending
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
