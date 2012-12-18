<?php
    require_once('../libs/pgsql.inc.php');

    $query = "SELECT MIN(username) from users GROUP BY id HAVING id=" . $_GET['id'];
    dbQuery($query);
?>
