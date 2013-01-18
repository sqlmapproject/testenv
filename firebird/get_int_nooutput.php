<?php
    require_once('../libs/firebird.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " ROWS 1";
    dbQuery($query, false, true, false);
?>
