<?php
    require_once('../libs/mssql.inc.php');

    $query = "SELECT * FROM users WHERE id=(" . $_POST['id'] . ")";
    dbQuery($query);
?>
