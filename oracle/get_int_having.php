<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT MIN(name) from scott.users GROUP BY id HAVING id=" . $_GET['id'];
    dbQuery($query);
?>
