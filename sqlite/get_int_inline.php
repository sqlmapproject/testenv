<?php
    require_once('../libs/sqlite.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
