<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
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

        // Perform SQL injection affected query
        $result = mysql_query($query);

        if (!$result or !mysql_num_rows($result)) {
            if ($show_errors)
                print "<b>SQL error:</b> ". mysql_error() . "<br>\n";
            exit(1);
        }

        header("Location: /");
        exit(1);
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);?>
