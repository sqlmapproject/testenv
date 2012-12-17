<?php
    /*
        CREATE TABLE users (
            id INTEGER,
            name TEXT,
            surname TEXT
        );

        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the SQLite database file
        // NOTE: it is installed on localhost
        $link = sqlite_open('/opt/sqlite/testdb.sqlite', 0666, $sqliteerror);
        
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
            print "<b>SQL error:</b> ". sqlite_error_string(sqlite_last_error($link)) . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = sqlite_fetch_array($result, SQLITE_ASSOC)) {
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
