<?php
    class Members {
        private $db;
        private $conn;

        public $members;

        function __construct($db) {
            $this->db = $db;
            $this->conn = $this->db->getConnection();
        }

        public function get_from_db() {
            $response = [
                'data' => [],
                'message' => '',
                'status' => true
            ];

            $sql = "SELECT name, surname, patronymic, birthdate, position, department, employmentdate FROM members";
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                $response['status'] = false;
                $response['message'] = 'sql query error';
                $response['data'] = null;
                return $response;
            }
            else {
                while($member = mysqli_fetch_assoc($result)) {
                    array_push($response['data'], $member);
                }

                $reponse['message'] = 'success';
            }

            return $response;
        }
    }
?>