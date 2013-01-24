<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

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
            if ($show_errors)
                print "<b>SQL error:</b> ". ingres_error() . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        //while ($line = ingres_fetch_assoc($result)) { // on PECL Ingres > 2
        while ($line = ingres_fetch_array($result)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
            if (!$all_results)
                break;
        }

        print "</table>\n";
        print "</body></html>";
    }
?>
