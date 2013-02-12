<?php
    require_once('../libs/pgsql_user.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
