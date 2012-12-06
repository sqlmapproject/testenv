<?php
    require_once('../libs/mssql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_COOKIE['id'];
    dbQuery($query);
?>
