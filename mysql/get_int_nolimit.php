<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id>=" . $_GET['id'];
    dbQuery($query);
?>
