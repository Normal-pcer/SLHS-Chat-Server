<?php
require 'sql.php';

$user_id = $_POST['user_id'];
$chat_id = $_POST['chat_id'];
$content = $_POST['content'];
$token = $_POST['token'];

$conn = connect_database();

$sql = 'SELECT * FROM `users` WHERE `user_id` = ' . $user_id;
$user = $conn->query($sql);
$user = $user->fetch_assoc();
if ($token != $user['last_token'])
    die('{"status": "error", "info": "wrong_token"}');

$sql = 'INSERT INTO `messages` VALUES (null, ' . $user_id .
    ', ' . $chat_id . ', "' . str_replace("\"", "\\\"", $content) . '", ' . time() . ')';
echo $sql;
if ($conn->query($sql)) {
    echo '{"status": "OK", "info": "success"}';
}
