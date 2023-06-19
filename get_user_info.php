<?php
require 'sql.php';

$user_id = $_POST['user_id'];
$get_chats = false;
$sql = '';
if (array_key_exists('get_chats', $_POST) && $_POST['get_chats'])
    $sql = 'SELECT `users`.user_id,`users`.username,`users`.avatar, JSON_ARRAYAGG(chats.chat_id) AS chats FROM users, chats WHERE users.user_id = %uid% AND JSON_CONTAINS(chats.members, CAST(%uid% AS JSON), "$")';
else
    $sql = 'SELECT `users`.user_id,`users`.username,`users`.avatar FROM users WHERE users.user_id=%uid%';

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
