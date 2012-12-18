<pre>
Used SQL schema:

CREATE TABLE IF NOT EXISTS `data` (
    `id` int(11) NOT NULL,
    `content` varchar(500) blob default NULL,
    PRIMARY KEY  (`id`)
);

INSERT INTO `data` (`id`, `content`) VALUES 
    (1, LOAD_FILE('/usr/bin/zdump')),
    (2, LOAD_FILE('/usr/bin/yes')),
    (3, LOAD_FILE('/usr/bin/volname'));
</pre>

<?php
    require_once('../libs/mysql.inc.php');

    $query = "SELECT * FROM data WHERE id=" . $_GET['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
