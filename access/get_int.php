<?php
    require_once('../libs/access.inc.php');

    $query = "SELECT * FROM users WHERE id='" . $_GET['id'] . "'";
    dbQuery($query);
?>
