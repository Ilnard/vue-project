<?php
    require_once '../../headers.php';
    require_once '../../objects/member.php';
    require_once '../../config/generalDatabase.php';

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $db = new GeneralDatabase();

    $member = new Member($db, $data);
    $response = $member->add_to_db();
        
    echo json_encode($response);
?>