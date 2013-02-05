<?php
    require_once('../libs/sqlite3.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query, false, false, true);
?>
