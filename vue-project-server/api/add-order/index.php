<?php
require_once '../../headers.php';
require_once '../../objects/order.php';
require_once '../../config/generalDatabase.php';
require_once '../../config/attachmentsDatabase.php';

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$db_general = new GeneralDatabase();
$db_attachemnts = new AttachmentsDatabase();

$order = new Order($db_general, $db_attachemnts, $data);

switch ($data['mode']) {
    case 'standart': {
        $response = $order->add_to_db();
        break;
    }
    case 'edit': {
        $response = $order->update();
        break;
    }
}

echo json_encode($response);
