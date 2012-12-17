<?php
    /*
        CREATE DATABASE testdb;

        USE testdb;

        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL,
            `name` varchar(500) default NULL,
            `surname` varchar(1000) default NULL,
            PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

        INSERT INTO `users` (`id`, `name`, `surname`) VALUES 
            (1, 'luther', 'blissett'),
            (2, 'fluffy', 'bunny'),
            (3, 'wu', 'ming'),
            (4, NULL, 'nameisnull');
    */

    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query) {
        // Connect to the MySQL database management system
        // NOTE: it is installed on localhost
        $link = mysql_pconnect("localhost", "root", "");
        if (!$link) {
            die(mysql_error());
        }

        // Make 'testdb' the current database
        $db_selected = mysql_select_db("testdb");
        if (!$db_selected) {
            die (mysql_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $result = mysql_query($query);

        if (!$result) {
            print "<b>SQL error:</b> ". mysql_error() . "<br>\n";
            exit(1);
        }

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
            print "<tr>";
            $i = 1;
            foreach ($line as $col_value) {
                if ($i == 1 || $i == 3)
                {
                    print "<td>" . substr($col_value, 0, 16) . "</td>";
                }
                else
                {
                    print "<td>" . $col_value . "</td>";
                }
                $i += 1;
            }
            print "</tr>\n";
        }

        print "</table>\n";
        print "</body></html>";
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
