<?php
    require_once('../libs/sqlite3.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
