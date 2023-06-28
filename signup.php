<?php
require 'sql.php';
$email = $_POST['email'];
$username = $_POST['username'];
$pass = $_POST['password'];
$db = connect_database();

$sql = 'SELECT * FROM `users` WHERE `email`="' . $email . '"';
$rst = $db->query($sql);

if ($rst->fetch_assoc()) {
    echo '{"status": "error", "info": "email_used"}';
} else {
    $hashed_pass = hash('sha256', $pass);
    $username = str_replace("\"", "\\\"", $username);
    $sql = 'INSERT INTO `users` VALUES (NULL, "%name%", "%pass%", "%email%", "/images/default-avatar.png", "[]", -1)';
    $sql = str_replace('%name%', $username, str_replace('%pass%', $hashed_pass, str_replace('%email%', $email, $sql)));
    $db->query($sql);
    $sql = 'SELECT `user_id` FROM `users` ORDER BY `user_id` DESC LIMIT 1';
    $rst = $db->query($sql)->fetch_assoc();
    echo '{"status": "ok", "info": "none", "id": ' . $rst['user_id'] . '}';
}
