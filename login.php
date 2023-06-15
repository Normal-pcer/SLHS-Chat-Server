<?php
require 'sql.php';

$user_id = $_POST['user_id'];
$password = $_POST['password'];

$sql = 'SELECT * FROM `users` WHERE `user_id`=' . $user_id;
$result = run_sql($sql);

if ($result) {
    $user_info = $result->fetch_assoc();
    $password_on_server = $user_info['password'];
    $password_from_client = hash('sha256', $password);

    if ($password_on_server != $password_from_client) {
        echo '{"success": false, "token": "-1", "info": "password_wrong"}';
    } else {
        $token = md5($password . uniqid());
        echo '{"success": true, "token": "' . $token . '", "info": "success_login"}';
        run_sql('UPDATE `users` SET `last_token`="' . $token .
            '"WHERE `users`.`user_id`=' . $user_id);
    }
} else {
    echo '{"success": false, "token": "-1", "info": "user_not_found"}';
}
