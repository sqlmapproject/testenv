<?php
    require_once('../libs/maxdb.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
