<?php
function query($sql) {
    $db = new mysqli('localhost', 'root', '', 'vue-project-db');
    $response = mysqli_query($db, $sql);
    mysqli_close($db);
    return $response;
}
?>