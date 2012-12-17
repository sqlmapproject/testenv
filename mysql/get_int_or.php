<?php
    require_once('../libs/mysql.inc.php');
    $link = mysql_connect('localhost', 'root', 'testpass') OR die(mysql_error());
    $query = "SELECT * FROM users WHERE id=" . mysql_real_escape_string($_GET['id1']) ." OR id=" . $_GET['id2'] ." OR id=" . mysql_real_escape_string($_GET['id3']) ." LIMIT 0, 1";
    
    dbQuery($query);
?>
