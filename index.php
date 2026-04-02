<?php
header("Content-Type: application/json");

echo json_encode([
    "status" => "success",
    "message" => "Workshop API is running 🚀",
    "version" => "1.0.0"
]);
