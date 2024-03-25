<?php
    require_once '../../headers.php';
    require_once '../../objects/members.php';
    require_once '../../config/generalDatabase.php';

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $db = new GeneralDatabase();

    $members = new Members($db);
    $response = $members->get_from_db();
        
    echo json_encode($response);
?>