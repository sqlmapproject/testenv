<?php
    require_once('../libs/pgsql.inc.php');

    $query = "SELECT * FROM users ORDER BY " . $_GET['id'];
    dbQuery($query);
?>
