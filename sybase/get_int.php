<?php
    require_once('../libs/sybase.inc.php');

    $query = "SELECT TOP 1 * FROM users WHERE id=" . $_GET['id']; //http://www.dbforums.com/sybase/1636087-sybase-equivalent-mysql-limit.html
    dbQuery($query);
?>
