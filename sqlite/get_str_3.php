<?php
    require_once('../libs/sqlite3.inc.php');

    $query = "SELECT * FROM users WHERE id='" . $_GET['id'] . "'";
    dbQuery($query);
?>
