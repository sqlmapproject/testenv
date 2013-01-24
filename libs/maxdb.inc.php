<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the MaxDB database management system
        $link = maxdb_connect("localhost", "ROOT", "TESTPASS", "testdb"); // implicitly usernames and passwords are all upper case
        if (!$link) {
            die(maxdb_connect_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = maxdb_query($link, $query);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". maxdb_error($link) . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = maxdb_fetch_array($result, MAXDB_ASSOC)) {
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
