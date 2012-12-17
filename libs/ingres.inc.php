<?php
    /*
        createdb testdb (from 'Ingres Command Prompt')

        CREATE TABLE users (
            id INTEGER,
            name VARCHAR(500),
            surname VARCHAR(1000)
        )
        
        INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
        INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
        INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
        INSERT INTO users (id, name, surname) VALUES (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the Ingres database management system
        $link = ingres_pconnect("testdb", "root", "testpass");
        if (!$link) {
            die(ingres_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        //$result = ingres_query($link, $query); // on PECL Ingres > 2
        $result = ingres_query($query, $link);

        if (!$result) {
            print "<b>SQL error:</b> ". ingres_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        //while ($line = ingres_fetch_assoc($result)) { // on PECL Ingres > 2
        while ($line = ingres_fetch_array($result)) {
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
