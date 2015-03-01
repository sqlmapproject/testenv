<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users LIMIT " . $_GET[id] . ", 1";
    dbQuery($query);
?>
