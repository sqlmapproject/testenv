<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_SERVER['HTTP_REFERER'] . " LIMIT 0, 1";
    dbQuery($query);
?>
