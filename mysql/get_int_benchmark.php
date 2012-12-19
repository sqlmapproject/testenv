<?php
    require_once('../libs/mysql.inc.php');

    sleep(5);

    if (strripos($_GET['id'], 'BENCHMARK') == false) {
        die ("DAMN YOU HACKERS");
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
