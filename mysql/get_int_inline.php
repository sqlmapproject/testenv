<?php
    require_once('../libs/mysql.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
