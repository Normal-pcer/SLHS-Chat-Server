<?php
require 'sql.php';

for ($i = 0; $i < 10; $i++) {
    run_sql('INSERT INTO `username`.`messages` VALUES (NULL, 1, 1, "TEST MESSAGE", ' . $i * 1145 . ')');
    run_sql('INSERT INTO `username`.`messages` VALUES (NULL, 2, 1, "TEST MESSAGE", ' . $i * 1145 . ')');
}
