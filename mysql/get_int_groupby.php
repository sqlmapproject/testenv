<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users GROUP BY " . $_GET['id'];
    dbQuery($query);
?>
