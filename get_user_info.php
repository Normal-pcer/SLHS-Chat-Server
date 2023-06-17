<?php
require 'sql.php';

$user_id = $_POST['user_id'];

$sql = 'SELECT * FROM `users` WHERE `user_id`=%uid%';
$sql = str_replace('%uid%', $user_id, $sql);

$rst = connect_database()->query($sql);
if ($rst) {
    $d = $rst->fetch_assoc();
    $data = [
        "status" => "ok",
        "data" => $d
    ];
    echo json_encode($data);
} else {
    echo '{"status": "error", "info": "user_not_found"}';
}
