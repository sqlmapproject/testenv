<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE name='" . $_GET['name'] . "' LIMIT 0, 1";
    dbQuery($query);
?>
