<?php
class Order
{
    private $db_general;
    private $conn_general;

    private $db_attachments;
    private $conn_attachments;

    public $id;
    public $number;
    public $client;
    public $title;
    public $datetime;
    public $endpoint;
    public $pay;
    public $status;
    public $allowed;
    public $not_allowed;

    function __construct($db_general, $db_attachments, $data)
    {
        $this->db_general = $db_general;
        $this->conn_general = $this->db_general->getConnection();

        $this->db_attachments = $db_attachments;
        $this->conn_attachments = $this->db_attachments->getConnection();

        $this->id = $data['id'];
        $this->number = $data['number'];
        $this->client = $data['client'];
        $this->title = $data['title'];
        $this->datetime = $data['datetime'];
        $this->endpoint = $data['endpoint'];
        $this->pay = $data['pay'];
        $this->status = $data['status'];
        $this->allowed = $data['allowed'];
        $this->not_allowed = $data['notAllowed'];
    }

    public function add_to_db()
    {
        $response = [
            'status' => true,
            'message' => '',
        ];

        $sql = "INSERT INTO orders (number, client, title, datetime, endpoint, pay, status) VALUES ($this->number, '$this->client', '$this->title', '$this->datetime', ";
        if ($this->endpoint) $sql .= "'$this->endpoint', ";
        else $sql .= "NULL, ";
        $sql .= "$this->pay, '$this->status')";
        $result = mysqli_query($this->conn_general, $sql);

        if ($result) {
            $sql = "SELECT id FROM orders WHERE number = $this->number";
            $result = mysqli_query($this->conn_general, $sql);
            if ($result) {
                $order_id = mysqli_fetch_assoc($result)['id'];

                $sql = "CREATE TABLE IF NOT EXISTS `$order_id` (id int NOT NULL AUTO_INCREMENT, member_id int, allowed tinyint(1), pay int, PRIMARY KEY (id))AUTO_INCREMENT=1";
                $result = mysqli_query($this->conn_attachments, $sql);
                if ($result) {
                    $result1 = '';
                    $result2 = '';
                    if (count($this->allowed)) {
                        $sql = "INSERT INTO `$order_id` (member_id, allowed, pay) VALUES";
                        foreach ($this->allowed as $member) {
                            $sql .= " ($member[id], 1, $member[pay]),";
                        }
                        $sql = mb_substr($sql, 0, -1);
                        $result1 = mysqli_query($this->conn_attachments, $sql);
                    }
                    if (count($this->not_allowed)) {
                        $sql = "INSERT INTO `$order_id` (member_id, allowed) VALUES";
                        foreach ($this->not_allowed as $member_id) {
                            $sql .= " ($member_id, 0),";
                        }
                        $sql = mb_substr($sql, 0, -1);
                        $result2 = mysqli_query($this->conn_attachments, $sql);
                    }
                    $response['message'] = "Заказ успешно добавлен";
                } else {
                    $response['status'] = false;
                    $response['message'] = "Не получилось создать таблицу привязанностей ($sql)";
                    return $response;
                }
                $response['message'] = 'success';
            } else {
                $response['status'] = false;
                $response['message'] = "Не получилось взять id ($sql)";
                return $response;
            }
        } else {
            $response['status'] = false;
            $response['message'] = "Не получилось добавить данные в базу данных ($sql)";
            return $response;
        }

        return $response;
    }
    public function update()
    {
        $response = [
            'status' => true,
            'message' => ''
        ];

        $sql = "UPDATE orders SET number = $this->number, client = '$this->client', title = '$this->title', datetime = '$this->datetime'";
        if ($this->endpoint) {
            $sql .= ", endpoint = '$this->endpoint'";
        }
        else {
            $sql .= ", endpoint = NULL";
        }
        $sql .= ", pay = $this->pay, status = '$this->status' WHERE id = $this->id";
        $result = mysqli_query($this->conn_general, $sql);
        if ($result) {
            $sql = "TRUNCATE `$this->id`";
            $result = mysqli_query($this->conn_attachments, $sql);
            if ($result) {
                $result1 = '';
                $result2 = '';
                if (count($this->allowed)) {
                    $sql = "INSERT INTO `$this->id` (member_id, allowed, pay) VALUES";
                    foreach ($this->allowed as $member) {
                        $sql .= " ($member[id], 1, $member[pay]),";
                    }
                    $sql = mb_substr($sql, 0, -1);
                    $result1 = mysqli_query($this->conn_attachments, $sql);
                }
                if (count($this->not_allowed)) {
                    $sql = "INSERT INTO `$this->id` (member_id, allowed) VALUES";
                    foreach ($this->not_allowed as $member_id) {
                        $sql .= " ($member_id, 0),";
                    }
                    $sql = mb_substr($sql, 0, -1);
                    $result2 = mysqli_query($this->conn_attachments, $sql);
                }
                $response['message'] = "Заказ успешно обновлен";
            }
            else {
                $response['status'] = false;
                $response['message'] = "Не получилось удалить старые привязанности ($sql)";
            }
        }
        else {
            $response['status'] = false;
            $response['message'] = "Не получилось обновить заказ ($sql)";
        }
        return $response;
    }
    public function get_from_db()
    {
        $response = [
            'data' => [],
            'status' => true,
            'message' => '',
        ];

        $sql = "SELECT * FROM orders WHERE number = $this->number";
        $result = mysqli_query($this->conn_general, $sql);

        if ($result) {
            $order = mysqli_fetch_assoc($result);

            $sql = "SELECT member_id, allowed, pay FROM `$order[id]`";
            $result = mysqli_query($this->conn_attachments, $sql);

            if ($result) {
                $order['attachmentList'] = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $sql = "SELECT name, surname, patronymic, position FROM members WHERE id = $row[member_id]";
                    $result2 = mysqli_query($this->conn_general, $sql);
                    if ($result2) {
                        $member = mysqli_fetch_assoc($result2);
                        $member_attachment = array_merge($row, $member);
                        array_push($order['attachmentList'], $member_attachment);
                    } else {
                        $response['status'] = false;
                        $response['message'] = "Сотрудник не найден ($sql)";
                        $response['data'] = null;
                        return $response;
                    }
                    $response['data'] = $order;
                }
            } else {
                $response['status'] = false;
                $response['message'] = "Привязанности не найдены ($sql)";
                $response['data'] = null;
                return $response;
            }
        } else {
            $response['status'] = false;
            $response['message'] = "Заказ не найден ($sql)";
            $response['data'] = null;
            return $response;
        }

        return $response;
    }
}
