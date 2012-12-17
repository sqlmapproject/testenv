<?php
    /*
        CREATE DATABASE testdb;
        CONNECT TO testdb;
        
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
        // Connect to the DB2 database management system
        // NOTE: it is installed on localhost
        $link = db2_pconnect("testdb", "root", "testpass");
        if (!$link) {
            die(db2_conn_errormsg());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";
        
        // Perform SQL injection affected query
        $stmt = db2_prepare($link, $query);
        $result = db2_execute($stmt);

        if (!$result) {
            print "<b>SQL error:</b> ". db2_stmt_errormsg($stmt) . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = db2_fetch_assoc($result)) {
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
