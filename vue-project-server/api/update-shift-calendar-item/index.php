<?php
require_once('../../headers.php');
require_once '../../objects/shiftCalendarItem.php';
require_once '../../config/generalDatabase.php';
require_once '../../config/shiftCalendarDatabase.php';
require_once '../../config/attachmentsDatabase.php';

$response = [
    'data' => [],
    'status' => false,
    'message' => ''
];

$db_shiftCalendar = new ShiftCalendarDatabase();
$db_general = new GeneralDatabase();
$db_attachments = new AttachmentsDatabase();

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$shiftCalendarItem = new shiftCalendarItem($db_shiftCalendar, $db_general, $db_attachments, $data['date']);
$shiftCalendarItemData = $shiftCalendarItem->update_shift_calendar_item($data);

$response = $shiftCalendarItemData;

echo json_encode($response);