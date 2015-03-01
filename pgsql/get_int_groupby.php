<?php
    require_once('../libs/pgsql.inc.php');

    $query = "SELECT name FROM users GROUP BY " . $_GET['id'];
    dbQuery($query);
?>
