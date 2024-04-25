<?php
    class Orders {
        private $db;
        private $conn;

        public $orders;

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

            $sql = "SELECT id, number, client, title, datetime, endpoint, pay, status FROM orders";
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                $response['status'] = false;
                $response['message'] = 'sql query error';
                $response['data'] = null;
                return $response;
            }
            else {
                while($order = mysqli_fetch_assoc($result)) {
                    array_push($response['data'], $order);
                }

                $reponse['message'] = 'success';
            }

            return $response;
        }
    }
?>