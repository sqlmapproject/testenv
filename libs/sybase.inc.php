<?php
    /*
        CREATE DATABASE testdb
        GO

        USE testdb
        GO

        CREATE TABLE users (
            id INTEGER NOT NULL,
            name VARCHAR(500) DEFAULT NULL NULL,
            surname VARCHAR(1000) DEFAULT NULL NULL
        )
        GO

        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset')
        GO

        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny')
        GO

        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming')
        GO

        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull')
        GO

    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Sybase database management system
        // NOTE: it is installed on localhost
        $link = @sybase_pconnect("FILENOTFOUND", "sa", "");
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
            print "<b>SQL error:</b> ". sybase_get_last_message() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = sybase_fetch_assoc($result)) {
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
