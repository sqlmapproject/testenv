/*
Used SQL schema:

CREATE TABLE IF NOT EXISTS `international` (
    `id` int(11) NOT NULL,
    `name` varchar(500) CHARACTER SET UTF8 default NULL,
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `international` (`id`, `name`) VALUES 
    (1, CONVERT(0xc5a175c4877572616a USING utf8)),  # Sucuraj in Croatian
    (2, CONVERT(0xe995bfe6b19f USING utf8)),   # Jangtze in Chinese
    (3, CONVERT(0xd180d0b5d0bad0b020d09cd0bed181d0bad0b2d0b0 USING utf8));  # River Moscow in Russian
*/
<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        // Connect to the MySQL database management system
        $link = mysql_pconnect("localhost", "root", "testpass");
        if (!$link) {
            die(mysql_error());
        }

        mysql_set_charset("utf8", $link); // !MUST!

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
            if ($show_errors)
                print "<b>SQL error:</b> ". mysql_error() . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
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

    $query = "SELECT * FROM international WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
