<?php
    require_once('../../headers.php');
    require_once '../../objects/orders.php';
    require_once '../../config/generalDatabase.php';

    $db = new GeneralDatabase();

    $orders = new Orders($db);
    $response = $orders->get_from_db();

    echo json_encode($response);
?>