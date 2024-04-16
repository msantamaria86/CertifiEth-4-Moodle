<?php
$data = json_decode(file_get_contents('php://input'), true);

$signature = $data['signature'] ?? '';
$userAddress = $data['userAddress'] ?? '';

error_log("Received signature: $signature from address: $userAddress");
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Data received']);