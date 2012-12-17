<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT * FROM scott.users ORDER BY " . $_GET['id'];
    dbQuery($query);
?>
