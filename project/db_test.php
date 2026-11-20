<?php

header('Content-Type: application/json');

require_once __DIR__ . '/backend/config/db.php';

if (!isset($conn) || !$conn) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);

    exit;
}

$result = $conn->query("SELECT DATABASE() AS db_name");

if ($result) {

    $row = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "message" => "TiDB database connected successfully!",
        "database" => $row['db_name']
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database query failed"
    ]);
}

$conn->close();

?>