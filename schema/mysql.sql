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
    (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header'),
    (5, NULL, 'nameisnull');
