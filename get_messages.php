<?php
require_once 'sql.php';

$user_id = $_POST['user_id'];
$token = $_POST['token'];
$last = $_POST['last'];
$chat_id = $_POST['chat_id'];

$usr = run_sql("SELECT * FROM `users` WHERE `user_id`=" . $user_id);
$usr = $usr->fetch_assoc();
if ($usr['last_token'] != $token)  die('{"status": "Error", "data": "wrong_token"}');

if ($chat_id == -1) {  // 未指定群聊
    $sql = 'SELECT * FROM `messages` WHERE JSON_CONTAINS((SELECT `members` FROM `chats` WHERE `messages`.`from`=`chats`.`chat_id` LIMIT 1), CAST(%user_id% AS JSON), "$") AND `messages`.`msg_id`>%lastid% ORDER BY `messages`.`time` DESC';
    $sql = str_replace(
        '%user_id%',
        $user_id,
        str_replace('%lastid%', $last, $sql)
    );
    $db_rst = run_sql($sql);
    $result = array();
    if ($db_rst) {
        while ($row = $db_rst->fetch_assoc()) {
            array_push($result, $row);
        }
    }
    echo '{"status": "OK", "data": ' . json_encode($result) . '}';
} else {  // 指定群聊
    $sql = 'SELECT * FROM `messages` WHERE `messages`.`from`=%cid% AND JSON_CONTAINS((SELECT `members` FROM `chats` WHERE %cid%=`chats`.`chat_id` LIMIT 1), CAST(%user_id% AS JSON), "$") AND `messages`.`msg_id`>%lastid% ORDER BY `messages`.`time` DESC';
    $sql = str_replace(
        '%user_id%',
        $user_id,
        str_replace(
            '%lastid%',
            $last,
            str_replace('%cid%', $chat_id, $sql)
        )
    );
    $db_rst = run_sql($sql);
    $result = array();
    if ($db_rst) {
        while ($row = $db_rst->fetch_assoc()) {
            array_push($result, $row);
        }
    }
    echo '{"status": "OK", "data": ' . json_encode($result) . '}';
}
