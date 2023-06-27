<?php
require 'sql.php';

$chat_id = $_POST['chat_id'];

$sql = 'SELECT * FROM `chats` WHERE `chat_id`=%cid%';
$sql = str_replace('%cid%', $chat_id, $sql);
$rst = connect_database()->query($sql);
if ($rst) {
    $d = $rst->fetch_assoc();
    $data = [
        "status" => "ok",
        "data" => $d
    ];
    echo json_encode($data);
} else {
    echo '{"status": "error", "info": "chat_not_found"}';
}
