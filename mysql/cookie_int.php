<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_COOKIE['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
