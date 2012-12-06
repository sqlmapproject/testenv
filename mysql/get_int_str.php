<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " AND name='" . $_GET['name'] . "' LIMIT 0, 1";
    dbQuery($query);
?>
