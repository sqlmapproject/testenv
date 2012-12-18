<?php
    function dbQuery($query) {
        // Connect to the MySQL database management system
        // NOTE: it is installed on localhost
        $link = mysql_pconnect("localhost", "root", "");
        if (!$link) {
            die(mysql_error());
        }

        // Make 'test' the current database
        $db_selected = mysql_select_db("testdb");
        if (!$db_selected) {
            die (mysql_error());
        }

        // Perform SQL injection affected query
        $result = mysql_query($query);

        if (!$result or !mysql_num_rows($result)) {
            print "<b>SQL error:</b> ". mysql_error() . "<br>\n";
            exit(1);
        }
        else
        {
            header("Location: .");
        }
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
