<?php
    function dbQuery($query) {
        // Connect to the MySQL database management system
        // NOTE: it is installed on localhost
        $link = mysql_pconnect("localhost", "root", "");
        if (!$link) {
            die(mysql_error());
        }

        // Make 'test' the current database
        $db_selected = mysql_select_db("testdb");
        if (!$db_selected) {
            die (mysql_error());
        }

        // Perform SQL injection affected query
        $result = mysql_query($query);

        if (!$result or !mysql_num_rows($result)) {
            header("Location: .");
            print "<b>SQL error:</b> ". mysql_error() . "<br>\n";
            exit(1);
        }
        else
        {
            // Print results in HTML
            print "<html><body>\n";
    
            print "<b>SQL results:</b>\n";
            print "<table border=\"1\">\n";
    
            while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
                print "<tr>";
                foreach ($line as $col_value) {
                    print "<td>" . $col_value . "</td>";
                }
                print "</tr>\n";
            }
    
            print "</table>\n";
            print "</body></html>";
        }
    }

    $query = "SELECT * FROM users WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
