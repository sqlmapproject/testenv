<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT id FROM scott.users GROUP BY " . $_GET['id'];
    dbQuery($query);
?>
