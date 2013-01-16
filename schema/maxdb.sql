sqlcli=> \c -d testdb -u root,testpass

CREATE TABLE users (id int NOT NULL,
    name varchar(500) default NULL,
    surname varchar(1000) default NULL,
    PRIMARY KEY  (id)
)

INSERT INTO users VALUES (1, 'luther', 'blisset')
INSERT INTO users VALUES (2, 'fluffy', 'bunny')
INSERT INTO users VALUES (3, 'wu', 'ming')
INSERT INTO users VALUES (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header')
INSERT INTO users VALUES (5, NULL, 'nameisnull')

