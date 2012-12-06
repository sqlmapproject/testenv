<?php
    require_once('../libs/mssql.inc.php');

    $query = "SELECT * FROM users WHERE name='" . $_SERVER['HTTP_USER_AGENT'] . "'";
    dbQuery($query);
?>
