<?php
    /*
        CREATE TABLE users (
            id INTEGER,
            name CHAR,
            surname CHAR
        );

        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
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
            print "<b>SQL error:</b> ". odbc_errormsg() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = odbc_fetch_array($result)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
        }

        print "</table>\n";
        print "</body></html>";
    }
?>
