<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE name='" . mysql_real_escape_string($_GET['name1']) ."' OR name='" . $_GET['name2'] ."' OR name='" . mysql_real_escape_string($_GET['name3']) ."' LIMIT 0, 1";
    dbQuery($query);
?>
