<?php
    require_once('../libs/informix.inc.php');

    $query = "SELECT id, name, surname FROM users WHERE id=" . $_GET['id'];
    dbQuery($query);
?>
