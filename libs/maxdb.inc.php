<?php
    /*
        sqlcli=> \c -d testdb -u root,testpass

        CREATE TABLE users (id int NOT NULL,
            name varchar(500) default NULL,
            surname varchar(1000) default NULL,
            PRIMARY KEY  (id)
        )

        INSERT INTO users VALUES (1, 'luther', 'blissett')
        INSERT INTO users VALUES (2, 'fluffy', 'bunny')
        INSERT INTO users VALUES (3, 'wu', 'ming')
        INSERT INTO users VALUES (4, NULL, 'nameisnull')
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the MaxDB database management system
        // NOTE: it is installed on localhost
        $link = maxdb_connect("localhost", "ROOT", "TESTPASS", "testdb"); //implicitly usernames and passwords are all upper case
        if (!$link) {
            die(maxdb_connect_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = maxdb_query($link, $query);

        if (!$result) {
            print "<b>SQL error:</b> ". maxdb_error($link) . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = maxdb_fetch_array($result, MAXDB_ASSOC)) {
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
