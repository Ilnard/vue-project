<?php
require_once('../../headers.php');
require_once '../../objects/order.php';
require_once '../../config/generalDatabase.php';

$db = new GeneralDatabase();

$data['number'] = $_GET['number'];

$order = new Order($db, $data);
$response = $order->get_from_db();

echo json_encode($response);
