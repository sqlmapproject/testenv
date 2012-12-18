<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM data WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
