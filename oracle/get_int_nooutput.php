<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query, false, true, false);
?>
