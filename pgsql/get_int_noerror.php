<?php
    require_once('../libs/pgsql.noerror.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " OFFSET 0 LIMIT 1";
    dbQuery($query);
?>
