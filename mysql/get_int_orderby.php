<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users ORDER BY " . $_GET['id'];
    dbQuery($query);
?>
