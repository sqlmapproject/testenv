<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the MS Access Database via ODBC connection (http://www.w3schools.com/PHP/php_db_odbc.asp)
        // NOTE: execute statements from above one at a time because MS Access doesn't support stacked SQL commands
        $link = odbc_connect("testdb", "", "");
        if (!$link) {
            die(odbc_errormsg());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = odbc_exec($link, $query);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". odbc_errormsg() . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = odbc_fetch_array($result)) {
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
