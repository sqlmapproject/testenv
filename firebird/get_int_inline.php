<?php
    require_once('../libs/firebird.inc.php');

    $query = $_GET['id'];
    dbQuery($query);
?>
