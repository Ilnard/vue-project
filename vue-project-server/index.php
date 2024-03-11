<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json;");

    $data = file_get_contents('php://input');
    $data = json_decode($data);

    echo json_encode([
        'message' => 'hello'
    ]);
?>