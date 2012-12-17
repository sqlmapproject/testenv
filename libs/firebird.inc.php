<?php
    /*
        CREATE TABLE users (
            id INTEGER,
            name VARCHAR(500),
            surname VARCHAR(1000)
        );
        
        COMMIT;

        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull');
        
        COMMIT;
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Firebird/Interbase Sybase database management system
        // NOTE: it is installed on localhost
        $link = ibase_pconnect("/opt/firebird/testdb.fdb", "SYSDBA", "testpass");
        if (!$link) {
            die(ibase_errmsg());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = ibase_query($link, $query);

        if (!$result) {
            print "<b>SQL error:</b> ". ibase_errmsg() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = ibase_fetch_assoc($result)) {
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
