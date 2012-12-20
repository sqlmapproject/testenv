<?php
    function dbQuery($query) {
        // Connect to the MySQL database management system
        $link = mysql_pconnect("localhost", "root", "testpass");
        if (!$link) {
            die(mysql_error());
        }

        // Make 'testdb' the current database
        $db_selected = mysql_select_db("testdb");
        if (!$db_selected) {
            die (mysql_error());
        }

        header("Content-Type: image/png");

        // Perform SQL injection affected query
        $result = mysql_query($query);

        if ((!$result)||(!($row = mysql_fetch_array($result, MYSQL_ASSOC)))) {
            $p = "./img/bad.png";
        }
        else
        {
            $p = "./img/ok.png";
        }
        header("Content-Length: ".filesize($p));
        readfile($p);
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
