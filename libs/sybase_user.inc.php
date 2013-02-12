<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the Sybase database management system
        $link = @sybase_pconnect("192.168.231.144", "testuser", "testpass");
        if (!$link) {
            die(sybase_get_last_message());
        }

        // Make 'testdb' the current database
        $db_selected = @sybase_select_db("testdb");
        if (!$db_selected) {
            die (sybase_get_last_message());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = sybase_query($query);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". sybase_get_last_message() . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = sybase_fetch_assoc($result)) {
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
?>
