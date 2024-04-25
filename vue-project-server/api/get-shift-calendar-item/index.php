<?php
require_once('../../headers.php');
require_once '../../objects/shiftCalendarItem.php';
require_once '../../objects/member.php';
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

$date = $_GET['date'];

$shiftCalendarItem = new shiftCalendarItem($db_shiftCalendar, $db_general, $db_attachments, $date);
$shiftCalendarItemData = $shiftCalendarItem->get_from_db();

$response = $shiftCalendarItemData;

$member = new Member($db_general);

if ($response['status']) {
    foreach ($response['data'] as &$order) {
        foreach ($order['attachments'] as &$attachment) {
            $memberData = $member->get_from_db($attachment['member_id']);
            $attachment['name'] = $memberData['data']['name'];
            $attachment['surname'] = $memberData['data']['surname'];
            $attachment['position'] = $memberData['data']['position'];
        }
        
        // $shiftCalendarItemData_Item['member']['name'] = $memberData['data']['name'];
        // $shiftCalendarItemData_Item['member']['surname'] = $memberData['data']['surname'];
        // $shiftCalendarItemData_Item['member']['patronymic'] = $memberData['data']['patronymic'];
        // $shiftCalendarItemData_Item['member']['position'] = $memberData['data']['position'];
        // $shiftCalendarItemData_Item['member']['department'] = $memberData['data']['department'];
        $response['message'] = $memberData['message'].': member';
        $response['status'] = $memberData['status'];
    };
}

echo json_encode($response);