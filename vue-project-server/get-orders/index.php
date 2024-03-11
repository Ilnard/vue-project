<?php
    require_once('../headers.php');
    require_once('../database.php');

    $data = json_decode($data, true);

    $response = [
        'code' => 0,
        'message' => '',
        'data' => null
    ];

    $query_data = [];
    $sql = "SELECT * FROM orders";
    $query_response = query($sql);
    while ($row = mysqli_fetch_assoc($query_response)) {
        array_push($query_data, $row);
    }
    // $query_response = query($sql);

    if (!$query_response) {
        $response['code'] = 1;
        $response['message'] = 'Ошибка запроса';
    }

    $response['data'] = $query_data;

    if ($response['code'] == 0) $response['status'] = true;
    else $response['status'] = false;

    echo json_encode($response);
?>