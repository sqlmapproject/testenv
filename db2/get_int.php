<?php
    require_once('../libs/db2.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
