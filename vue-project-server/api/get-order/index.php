<?php
require_once('../../headers.php');
require_once '../../objects/order.php';
require_once '../../config/generalDatabase.php';
require_once '../../config/attachmentsDatabase.php';

$db_general = new GeneralDatabase();
$db_attachments = new AttachmentsDatabase();

$data['number'] = $_GET['number'];

$order = new Order($db_general, $db_attachments, $data);
$response = $order->get_from_db();

echo json_encode($response);
