<?php
    require_once('../libs/pgsql.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
