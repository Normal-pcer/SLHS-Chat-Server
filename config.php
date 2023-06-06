<?php
function get_config() {
    $content = file_get_contents("config.json");
    $json = json_decode($content, true);
    return $json;
}

function set_config($new_config) {
    $string = json_encode($new_config);
    file_put_contents("config.json", $string);
}
