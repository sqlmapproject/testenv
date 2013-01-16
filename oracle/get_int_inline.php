<?php
    require_once('../libs/oracle.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
