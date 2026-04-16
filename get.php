<?php
require('database.php');
header("Content-Type: application/json");

if (!isset($_GET['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "user_id missing"
    ]);
    exit;
}

$user_id = intval($_GET['user_id']);

$stmt = $conn->prepare("SELECT * FROM workshop WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    echo json_encode([
        "status" => "success",
        "data" => $row
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Workshop not found"
    ]);

}

$stmt->close();
$conn->close();
?>
