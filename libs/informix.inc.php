<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        putenv("INFORMIXDIR=/opt/IBM/informix");
        putenv("INFORMIXSERVER=ol_informix1170");
        putenv("ONCONFIG=onconfig.ol_informix1170");
        putenv("INFORMIXSQLHOSTS=/opt/IBM/informix/etc/sqlhosts.ol_informix1170");
        putenv("LD_LIBRARY_PATH=/opt/IBM/informix/lib:/opt/IBM/informix/lib/cli:/opt/IBM/informix/lib/esql:/opt/IBM/informix/lib/tools");
        putenv("ODBCINI=/etc/odbc.ini");

        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the Informix database management system
        // NOTE: it is installed on localhost
        try {
            // Call the PDO class.
            $link= new PDO('informix:DSN=inf');
        }
        catch(PDOException $e) {
            // If something goes wrong, PDO throws an exception with a nice error message.
            echo $e->getMessage();
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $stmt = $link->query($query);
        $stmt->setFetchMode(PDO::FETCH_COLUMN);

        if (!$stmt) {
             exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while($row = $stmt->fetch()) {
            print "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "</tr>\n";
            if (!$all_results)
                break;
        }

        print "</table>\n";
        print "</body></html>";
    }
?>
