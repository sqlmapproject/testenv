<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
    print "<br>" . rand() . "<br>" . rand(); 
    print "<br>static line<br>";
    print rand();    
?>
