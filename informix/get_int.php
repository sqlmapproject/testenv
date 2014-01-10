<?php
    require_once('../libs/informix.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
