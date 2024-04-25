<?php
require_once '../../vendor/autoload.php';
require_once '../../headers.php';
require_once '../../config/generalDatabase.php';
require_once '../../config/jwtInfo.php';

use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents('php://input'), true);

$response = [
    'data' => '',
    'status' => true,
    'message' => '',
];

$db = new GeneralDatabase();
$conn = $db->getConnection();

$sql = "SELECT id, password FROM users WHERE login = '$data[login]'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $user_info = mysqli_fetch_assoc($result);
    if (password_verify($data['password'], $user_info['password'])) {
        $sql = "SELECT * FROM users WHERE id = $user_info[id]";
        $result = mysqli_query($conn, $sql);
        $user_info = mysqli_fetch_assoc($result);

        $sql = "SELECT name, surname, patronymic FROM members WHERE id = $user_info[member_id]";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $member_info = mysqli_fetch_assoc($result);
        } else {
            $response['status'] = false;
            $response['message'] = 'Член организации не найден';
        }
    } else {
        $response['status'] = false;
        $response['message'] = 'Пароль не верный';
    }
} else {
    $response['status'] = false;
    $response['message'] = 'Пользователь не найден';
}

if (mb_strlen($data['login']) && mb_strlen($data['password'])) {
    if ($response['status']) {
        $jwt_decoded = [
            "exp" => $exp,
            "user_id" => $user_info['id'],
            "member_id" => $user_info['member_id'],
            "role" => $user_info['role'],
            "name" => $member_info['name'],
            "surname" => $member_info['surname'],
            "patronymic" => $member_info['patronymic'],
        ];
        $jwt = JWT::encode($jwt_decoded, $key, 'HS256');

        $response['data'] = $jwt;
    }
} else {
    $response['status'] = false;
    $response['message'] = 'Есть пустые данные';
}

echo json_encode($response);
