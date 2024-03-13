<?php
    class Order {
        private $db;
        private $conn;

        public $number;
        public $client;
        public $title;
        public $datetime;
        public $pay;
        public $paid;
        public $status;

        function __construct($db, $data) {
            $this->db = $db;
            $this->conn = $this->db->getConnection();

            $this->number = $data['number'];
            $this->client = $data['client'];
            $this->title = $data['title'];
            $this->datetime = $data['datetime'];
            $this->pay = $data['pay'];
            $this->paid = $data['paid'];
            $this->status = $data['status'];
        }

        public function add_to_db() {
            $response = [
                'status' => true,
                'message' => '',
            ];

            $sql = "INSERT INTO orders (number, client, title, datetime, pay, paid, status) VALUES ($this->number, '$this->client', '$this->title', '$this->datetime', $this->pay, $this->paid, '$this->status')";
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

    }
?>