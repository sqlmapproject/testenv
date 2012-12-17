<?php
    /*
        CREATE DATABASE testdb;

        CREATE TABLE users (
            id integer,
            username character(5000),
            password character(1000)
        );

        INSERT INTO users VALUES (1, 'luther', 'blissett');
        INSERT INTO users VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users VALUES (3, 'wu', 'ming');
        INSERT INTO users VALUES (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the PostgreSQL database management system
        // PostgreSQL 8.2
        $link = pg_pconnect("host=localhost port=5432 dbname=testdb user=testuser password=testpass");
        if (!$link) {
            die(pg_last_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = pg_query($query);

        if (!$result) {
            print "<b>SQL error:</b> ". pg_last_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
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
