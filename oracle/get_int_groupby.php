<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT id FROM users GROUP BY " . $_GET['id'];
    dbQuery($query);
?>
