CREATE DATABASE testdb;

USE testdb;

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL,
    `name` varchar(500) default NULL,
    `surname` varchar(1000) default NULL,
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `surname`) VALUES 
    (1, 'luther', 'blisset'),
    (2, 'fluffy', 'bunny'),
    (3, 'wu', 'ming'),
    (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header'),
    (5, NULL, 'nameisnull');

CREATE TABLE IF NOT EXISTS `international` (
    `id` int(11) NOT NULL,
    `name` varchar(500) CHARACTER SET UTF8 default NULL,
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `international` (`id`, `name`) VALUES
    (1, CONVERT(0xc5a175c4877572616a USING utf8)),  # Sucuraj in Croatian
    (2, CONVERT(0xe995bfe6b19f USING utf8)),   # Jangtze in Chinese
    (3, CONVERT(0xd180d0b5d0bad0b020d09cd0bed181d0bad0b2d0b0 USING utf8));  # River Moscow in Russian

CREATE TABLE IF NOT EXISTS `data` (
    `id` int(11) NOT NULL,
    `content` blob default NULL,
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `data` (`id`, `content`) VALUES
    (1, LOAD_FILE('/usr/bin/zdump')),
    (2, LOAD_FILE('/usr/bin/yes')),
    (3, LOAD_FILE('/usr/bin/volname'));

CREATE USER 'testuser'@'%' identified by 'testpass';

USE mysql;

UPDATE user SET host='%' WHERE user='root' AND host='localhost';
GRANT SELECT ON testdb.* TO 'testuser'@'%';

