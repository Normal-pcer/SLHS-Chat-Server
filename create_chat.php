<?php
require 'sql.php';

$user_id = $_POST['user_id'];
$token = $_POST['token'];
$group_name = $_POST['name'];

$usr = run_sql("SELECT * FROM `users` WHERE `user_id`=" . $user_id);
$usr = $usr->fetch_assoc();
if ($usr['last_token'] != $token)  die('{"status": "Error", "data": "wrong_token"}');

$sql = "INSERT INTO `chats` VALUES (NULL, '[" . $user_id . "]', '" .
    str_replace("'", "\\'", $group_name) . "', '/images/default-avatar.png')";
run_sql($sql);

$rst = run_sql("SELECT `chat_id` FROM `chats` ORDER BY `chat_id` DESC LIMIT 1");
$last_id = $rst->fetch_assoc()['chat_id'];
echo ('{"status": "OK", "info": "none", "id": ' . $last_id . '}');
