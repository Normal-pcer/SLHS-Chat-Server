<?php
require 'sql.php';

$this_user_id = $_POST['this_user'];
$that_user_id = $_POST['that_user'];
$token = $_POST['token'];

$conn = connect_database();

$sql = 'SELECT * FROM `users` WHERE `user_id` = ' . $this_user_id;
$user = $conn->query($sql);
$user = $user->fetch_assoc();
if ($token != $user['last_token'])
    die('{"status": "error", "info": "wrong_token"}');

$sql = "UPDATE `users` SET `friends` = JSON_ARRAY_APPEND(`friends`, '$', %that%) WHERE `user_id`=%this%";
$sql1 = str_replace('%this%', $this_user_id, $sql);
$sql1 = str_replace('%that%', $that_user_id, $sql1);
run_sql($sql1);
$sql2 = str_replace('%that%', $this_user_id, $sql);
$sql2 = str_replace('%this%', $that_user_id, $sql2);
run_sql($sql2);

echo ('{"status": "ok", "info": "none"}');
