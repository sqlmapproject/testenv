<?php
    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        if ($show_errors)
            error_reporting(E_ALL);
        else
            error_reporting(E_PARSE);

        // Connect to the Oracle database management system
        $link = oci_pconnect('SYS', 'testpass', '//localhost/XE', null, OCI_SYSDBA);
        if (!$link) {
            die(oci_error());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $stid = oci_parse($link, $query);
        if (!$stid) {
          $e = oci_error($link);
          die(htmlentities($e['message']));
        }

        $result = oci_execute($stid, OCI_DEFAULT);

        if (!$result) {
            if ($show_errors) {
                $e = oci_error($stid);
                print "<b>SQL error:</b> ". $e['message'] . "<br>\n";
            }
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = oci_fetch_array($stid, OCI_ASSOC)) {
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
