<?php
    require_once '../../headers.php';
    require_once '../../objects/order.php';
    require_once '../../config/generalDatabase.php';

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $db = new GeneralDatabase();

    $order = new Order($db, $data);
    $response = $order->add_to_db();

    echo json_encode($response);
?>