<?php
    require_once('../libs/oracle_partialunion.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
