<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the SQLite database file
        $link = sqlite_open('/var/www/sqlmap/dbs/sqlite/testdb.sqlite', 0666, $sqliteerror);

        if (!$link) {
            die($sqliteerror);
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = sqlite_query($link, $query);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". sqlite_error_string(sqlite_last_error($link)) . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = sqlite_fetch_array($result, SQLITE_ASSOC)) {
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
