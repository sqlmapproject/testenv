<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);

    print "<p>Dynamic content: " . rand(1000, 9999999999) . "</p>";
?>
