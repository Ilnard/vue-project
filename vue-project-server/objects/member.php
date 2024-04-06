<?php
    class Member {
        private $db;
        private $conn;

        public $name;
        public $surname;
        public $patronymic;
        public $birthdate;
        public $position;
        public $department;
        public $employmentdate;

        function __construct($db, $data = []) {
            $this->db = $db;
            $this->conn = $this->db->getConnection();

            $this->name = $data['name'];
            $this->surname = $data['surnameme'];
            $this->patronymic = $data['patronymic'];
            $this->birthdate = $data['birthdate'];
            $this->position = $data['position'];
            $this->department = $data['department'];
            $this->employmentdate = $data['employmentdate'];
        }

        public function add_to_db() {
            $response = [
                'status' => true,
                'message' => '',
            ];

            $sql = "INSERT INTO members (name, surname, patronymic, birthdate, position, department, employmentdate) VALUES ('$this->name', '$this->surname', '$this->patronymic', '$this->birthdate', '$this->position', '$this->department', '$this->employmentdate')";
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                $response['status'] = false;
                $response['message'] = 'sql query error';
                return $response;
            }
            else {
                $response['message'] = 'success';
            }

            return $response;
        }

        public function get_from_db($member_id) {
            $response = [
                'data' => [],
                'status' => true,
                'message' => '',
            ];

            $sql = "SELECT name, surname, patronymic, birthdate, position, department, employmentdate, payment FROM members WHERE id = $member_id";
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                $response['status'] = false;
                $response['message'] = 'sql query error';
                return $response;
            }
            else {
                $response['data'] = mysqli_fetch_assoc($result);

                $response['message'] = 'success';
            }

            return $response;
        }
    }
?>