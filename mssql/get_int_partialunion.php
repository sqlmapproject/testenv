<?php
    require_once('../libs/mssql_partialunion.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
