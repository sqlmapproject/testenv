<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users LIMIT 1, " . $_GET[id];
    dbQuery($query);
?>
