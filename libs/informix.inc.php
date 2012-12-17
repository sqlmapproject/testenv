<?php
    /*
        CREATE DATABASE testdb;
        DATABASE testdb;
        
        CREATE TABLE users (
            id INTEGER,
            name VARCHAR(500),
            surname VARCHAR(1000)
        );

        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Informix database management system
        // NOTE: it is installed on localhost
        $link = ifx_pconnect("online_root@localhost", "", "");
        if (!$link) {
            die(ifx_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = ifx_query($query, $link);

        if (!$result) {
            print "<b>SQL error:</b> ". ifx_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = ifx_fetch_row($result)) {
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
