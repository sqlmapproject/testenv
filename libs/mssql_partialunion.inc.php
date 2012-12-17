<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Microsoft SQL Server database management system
        // NOTE: it is installed on a Windows 2003 VMWare virtual machine
        $link = mssql_pconnect("172.16.213.128", "sa", "testpass");
        if (!$link) {
            die(mssql_get_last_message());
        }

        // Make 'master' the current database
        $db_selected = mssql_select_db("testdb", $link);
        if (!$db_selected) {
            die (mssql_get_last_message());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = mssql_query($query);

        if (!$result) {
            print "<b>SQL error:</b> ". mssql_get_last_message() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = mssql_fetch_array($result, MSSQL_ASSOC)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
            break;
        }

        print "</table>\n";
        print "</body></html>";
    }
?>
