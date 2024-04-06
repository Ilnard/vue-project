<?php
class ShiftCalendarItem
{
    private $db_shiftCalendar;
    private $conn_shiftCalendar;

    private $db_general;
    private $conn_general;

    public $date;
    public $user_id;
    public $status;
    public $hours;
    public $reason;

    function __construct($db_shiftCalendar, $db_general, $date)
    {
        $this->db_shiftCalendar = $db_shiftCalendar;
        $this->conn_shiftCalendar = $this->db_shiftCalendar->getConnection();

        $this->db_general = $db_general;
        $this->conn_general = $this->db_general->getConnection();

        $this->date = $date;
    }

    public function get_from_db()
    {
        $response = [
            'data' => [],
            'status' => true,
            'message' => '',
        ];

        $sql = "CREATE TABLE IF NOT EXISTS `$this->date` (id int NOT NULL AUTO_INCREMENT, member_id int, hours float, reason text, PRIMARY KEY (id))AUTO_INCREMENT=1";
        $result = mysqli_query($this->conn_shiftCalendar, $sql);

        if (!$result) {
            $response['status'] = false;
            $response['message'] = 'sql query error ' . $sql;
            $response['data'] = null;
            return $response;
        } else {
            $sql = "SELECT id FROM members";
            $result = mysqli_query($this->conn_general, $sql);

            if (!$result) {
                $response['status'] = false;
                $response['message'] = 'sql query error ' . $sql;
                $response['data'] = null;
                return $response;
            } else {
                $members_id = [];
                while ($member = mysqli_fetch_assoc($result)) {
                    array_push($members_id, $member['id']);
                }
                $sql = "SELECT id, member_id, hours, reason FROM `$this->date`";
                $result = mysqli_query($this->conn_shiftCalendar, $sql);

                if (!$result) {
                    $response['status'] = false;
                    $response['message'] = 'sql query error ' . $sql;
                    $response['data'] = null;
                    return $response;
                } else {
                    $members_id_userShift = [];
                    while ($userShift = mysqli_fetch_assoc($result)) {
                        $newUserShift['member']['id'] = $userShift['member_id'];
                        $newUserShift['status'] = $userShift['status'];
                        $newUserShift['hours'] = $userShift['hours'];
                        $newUserShift['reason'] = $userShift['reason'];
                        array_push($response['data'], $newUserShift);
                        array_push($members_id_userShift, $userShift['member_id']);
                    }
                    
                    $members_id_diff = array_diff($members_id, $members_id_userShift);
                    if (count($members_id_diff)) {
                        $sql = "INSERT INTO `$this->date` (member_id, hours) VALUES";
                        foreach ($members_id_diff as $member_id_diff) {
                            $sql = $sql . " ($member_id_diff, 0),";
                            $newUserShift['member']['id'] = $member_id_diff;
                            $newUserShift['hours'] = 0;
                            $newUserShift['reason'] = '';
                        }
                        $sql = mb_substr($sql, 0, -1);
                        $result = mysqli_query($this->conn_shiftCalendar, $sql);
                        if (!$result) {
                            $response['status'] = false;
                            $response['message'] = 'sql query error ' . $sql;
                            $response['data'] = null;
                            
                            return $response;
                        } else {
                            $reponse['message'] = 'success';
                        }
                    }
                    else {
                        $reponse['message'] = 'success';
                    }
                    
                }
            }
        }

        return $response;
    }
}
