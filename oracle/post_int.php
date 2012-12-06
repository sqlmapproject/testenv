<?php
    require_once('../libs/oracle.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_POST['id'];
    dbQuery($query);
?>
