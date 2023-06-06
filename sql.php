<?php 
function connect_database(){
    require_once 'config.php';
    $conf = get_config()['database'];
    $host = $conf['host'];
    $user = $conf['user'];
    $password = $conf['password'];
    $name = $conf['name'];

    $conn = new mysqli($host, $user, $password, $name);
    return $conn;
}

function run_sql($sql) {
    $connection = connect_database();
    $result = $connection->query($sql);
    return $result;
}