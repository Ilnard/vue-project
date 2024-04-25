<?php
class ShiftCalendarItem
{
    private $db_shiftCalendar;
    private $conn_shiftCalendar;

    private $db_general;
    private $conn_general;

    private $db_attachments;
    private $conn_attachments;

    public $date;
    public $user_id;
    public $status;
    public $hours;
    public $reason;

    function __construct($db_shiftCalendar, $db_general, $db_attachments, $date)
    {
        $this->db_shiftCalendar = $db_shiftCalendar;
        $this->conn_shiftCalendar = $this->db_shiftCalendar->getConnection();

        $this->db_general = $db_general;
        $this->conn_general = $this->db_general->getConnection();

        $this->db_attachments = $db_attachments;
        $this->conn_attachments = $this->db_attachments->getConnection();

        $this->date = $date;
    }

    public function get_from_db()
    {
        $response = [
            'data' => [],
            'status' => true,
            'message' => '',
        ];

        $sql = "CREATE TABLE IF NOT EXISTS `$this->date` (id int NOT NULL AUTO_INCREMENT, order_id int, member_id int, hours float, reason text, PRIMARY KEY (id))AUTO_INCREMENT=1";
        $result = mysqli_query($this->conn_shiftCalendar, $sql);

        if ($result) {
            $shifts = [];
            $sql = "SELECT order_id, member_id FROM `$this->date`";
            $result = mysqli_query($this->conn_shiftCalendar, $sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($shifts, $row);
                }

                $sql = "SELECT id, number, title, datetime, endpoint, status FROM orders";
                $result = mysqli_query($this->conn_general, $sql);

                if ($result) {
                    $current_shifts = [];
                    while ($order = mysqli_fetch_assoc($result)) {

                        if ($order['status'] == 'Завершена') {
                            if (mb_substr($order['endpoint'], 0, -9) != $this->date) continue;
                        }
                        $order['attachments'] = [];

                        $sql = "SELECT member_id, pay FROM `$order[id]`";
                        $result2 = mysqli_query($this->conn_attachments, $sql);

                        if ($result2) {
                            while ($attachment = mysqli_fetch_assoc($result2)) {
                                array_push($order['attachments'], $attachment);
                                array_push($current_shifts, [
                                    "order_id" => $order['id'],
                                    "member_id" => $attachment['member_id']
                                ]);
                            }
                        } else {
                            $response['status'] = false;
                            $response['message'] = "Не удалось найти привязанности к заказу ($sql)";
                            $response['data'] = null;
                            return $response;
                        }
                        array_push($response['data'], $order);
                    }
                    $shifts_diff = array_diff($current_shifts, $shifts);

                    if (count($shifts_diff)) {
                        $sql = "INSERT INTO `$this->date` (order_id, member_id, hours) VALUES";
                        foreach ($shifts_diff as $shift) {
                            $sql .= " ($shift[order_id], $shift[member_id], 0),";
                        }
                        $sql = mb_substr($sql, 0, -1);
                        $result = mysqli_query($this->conn_shiftCalendar, $sql);
                        if (!$result) {
                            $response['status'] = false;
                            $response['message'] = "Не получилось вставить данные из разницы ($sql)";
                            $response['data'] = null;
                            return $response;
                        }
                    }
                    foreach ($response['data'] as &$order) {
                        foreach ($order['attachments'] as &$attachment) {
                            $sql = "SELECT hours, reason FROM `$this->date` WHERE order_id = $order[id] AND member_id = $attachment[member_id]";
                            $result = mysqli_query($this->conn_shiftCalendar, $sql);
                            if ($result) {
                                $current_shift = mysqli_fetch_assoc($result);
                                $attachment['hours'] = $current_shift['hours'];
                                $attachment['reason'] = $current_shift['reason'];
                            } else {
                                $response['status'] = false;
                                $response['message'] = "Не удалось получить 'часы' и 'причину' для данной привязанности ($sql)";
                                $response['data'] = null;
                                return $response;
                            }
                        }
                    }
                } else {
                    $response['status'] = false;
                    $response['message'] = "Не удалось найти заказы ($sql)";
                    $response['data'] = null;
                    return $response;
                }
            } else {
                $response['status'] = false;
                $response['message'] = "Не удалось найти данные текущей смены ($sql)";
                $response['data'] = null;
                return $response;
            }
        } else {
            $response['status'] = false;
            $response['message'] = "Не удалось создать таблицу ($sql)";
            $response['data'] = null;
            return $response;
        }

        // if (!$result) {
        //     $response['status'] = false;
        //     $response['message'] = 'Не удалось создать таблицу' . $sql;
        //     $response['data'] = null;
        //     return $response;
        // } else {
        //     $sql = "SELECT id FROM members";
        //     $result = mysqli_query($this->conn_general, $sql);

        //     if (!$result) {
        //         $response['status'] = false;
        //         $response['message'] = 'sql query error ' . $sql;
        //         $response['data'] = null;
        //         return $response;
        //     } else {
        //         $members_id = [];
        //         while ($member = mysqli_fetch_assoc($result)) {
        //             array_push($members_id, $member['id']);
        //         }
        //         $sql = "SELECT id, member_id, hours, reason FROM `$this->date`";
        //         $result = mysqli_query($this->conn_shiftCalendar, $sql);

        //         if (!$result) {
        //             $response['status'] = false;
        //             $response['message'] = 'sql query error ' . $sql;
        //             $response['data'] = null;
        //             return $response;
        //         } else {
        //             $members_id_userShift = [];
        //             while ($userShift = mysqli_fetch_assoc($result)) {
        //                 $newUserShift['member']['id'] = $userShift['member_id'];
        //                 $newUserShift['status'] = $userShift['status'];
        //                 $newUserShift['hours'] = $userShift['hours'];
        //                 $newUserShift['reason'] = $userShift['reason'];
        //                 array_push($response['data'], $newUserShift);
        //                 array_push($members_id_userShift, $userShift['member_id']);
        //             }

        //             $members_id_diff = array_diff($members_id, $members_id_userShift);
        //             if (count($members_id_diff)) {
        //                 $sql = "INSERT INTO `$this->date` (member_id, hours) VALUES";
        //                 foreach ($members_id_diff as $member_id_diff) {
        //                     $sql = $sql . " ($member_id_diff, 0),";
        //                     $newUserShift['member']['id'] = $member_id_diff;
        //                     $newUserShift['hours'] = 0;
        //                     $newUserShift['reason'] = '';
        //                 }
        //                 $sql = mb_substr($sql, 0, -1);
        //                 $result = mysqli_query($this->conn_shiftCalendar, $sql);
        //                 if (!$result) {
        //                     $response['status'] = false;
        //                     $response['message'] = 'sql query error ' . $sql;
        //                     $response['data'] = null;

        //                     return $response;
        //                 } else {
        //                     $reponse['message'] = 'success';
        //                 }
        //             }
        //             else {
        //                 $reponse['message'] = 'success';
        //             }

        //         }
        //     }
        // }

        return $response;
    }
    public function update_shift_calendar_item($data)
    {
        $response = [
            'status' => true,
            'message' => '',
        ];

        $sql = "UPDATE `$this->date` SET hours = $data[hours]";

        if ($data['reason'] == '') {
            $sql .= ", reason = NULL";
        }
        else {
            $sql .= ", reason = '$data[reason]'";
        }

        $sql .= " WHERE order_id = $data[orderId] AND member_id = $data[memberId]";

        $result = mysqli_query($this->conn_shiftCalendar, $sql);
        if (!$result) {
            $response['status'] = false;
            $response['message'] = "Не удалось обновить данные ($sql)";
        }
        // , reason = $data[reason] WHERE order_id = $data[orderId] AND member_id = $data[memberId]"

        return $response;
    }
}
