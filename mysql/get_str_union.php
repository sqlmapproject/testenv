<?php
    require_once('../libs/mysql.inc.php');

    if (strripos($_GET['id'], 'AND ')) {
        die ("DAMN YOU HACKERS");
    }
    $query = "SELECT * FROM users WHERE id='" . $_GET['id'] . "' LIMIT 0, 1";
    dbQuery($query);
?>
