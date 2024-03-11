<?php
    require_once('../headers.php');
    require_once('../database.php');

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $response = [
        'code' => 0,
        'message' => '',
    ];

    $sql = "INSERT INTO orders (number, client, title, datetime, pay, paid, status) VALUES ($data[number], '$data[client]', '$data[title]', '$data[datetime]', $data[pay], $data[paid], '$data[status]')";
    $query_response = query($sql);

    if (!$query_response) {
        $response['code'] = 1;
        $response['message'] = 'Ошибка запроса';
    }

    if ($response['code'] == 0) $response['status'] = true;
    else $response['status'] = false;

    echo json_encode($response);
?>