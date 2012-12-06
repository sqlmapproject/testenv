<?php
    require_once('../libs/pgsql.inc.php');

    $query = "SELECT * FROM users WHERE name=\"" . $_SERVER['HTTP_USER_AGENT'] . "\" OFFSET 0 LIMIT 1";
    dbQuery($query);
?>
