<?php
require_once('../../headers.php');
require_once '../../objects/shiftCalendarItem.php';
require_once '../../objects/member.php';
require_once '../../config/generalDatabase.php';
require_once '../../config/shiftCalendarDatabase.php';

$response = [
    'data' => [],
    'status' => false,
    'message' => ''
];

$db_shiftCalendar = new ShiftCalendarDatabase();
$db_general = new GeneralDatabase();

$date = $_GET['date'];

$shiftCalendarItem = new shiftCalendarItem($db_shiftCalendar, $db_general, $date);
$shiftCalendarItemData = $shiftCalendarItem->get_from_db();

$response = $shiftCalendarItemData;

$member = new Member($db_general);

foreach ($response['data'] as &$shiftCalendarItemData_Item) {
    $memberData = $member->get_from_db($shiftCalendarItemData_Item['member']['id']);
    $shiftCalendarItemData_Item['member']['name'] = $memberData['data']['name'];
    $shiftCalendarItemData_Item['member']['surname'] = $memberData['data']['surname'];
    $shiftCalendarItemData_Item['member']['patronymic'] = $memberData['data']['patronymic'];
    $shiftCalendarItemData_Item['member']['position'] = $memberData['data']['position'];
    $shiftCalendarItemData_Item['member']['department'] = $memberData['data']['department'];
    $shiftCalendarItemData_Item['member']['payment'] = $memberData['data']['payment'];
    $response['message'] = $memberData['message'].': member';
    $response['status'] = $memberData['status'];
};

echo json_encode($response);