<?php
    require_once('../libs/mysql.inc.php');

    sleep(5);

    if (strripos($_GET['id'], 'SLEEP')) {
    die ("DAMN YOU HACKERS");
    }
    if (strripos($_GET['id'], 'BENCHMARK')) {
    die ("DAMN YOU HACKERS");
    }
    if (strripos($_GET['id'], 'AND')) {
    die ("DAMN YOU HACKERS");
    }
    if (strripos($_GET['id'], 'OR')) {
    die ("DAMN YOU HACKERS");
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
