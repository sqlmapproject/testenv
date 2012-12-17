<?php
    require_once('../libs/oracle_scott_partial.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
