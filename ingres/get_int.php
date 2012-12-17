<?php
    require_once('../libs/ingres.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
