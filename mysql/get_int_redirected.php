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
            header("Location: /");
            exit(1);
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
            if (!$all_results)
                break;
        }

        print "</table>\n";
        print "</body></html>";
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
