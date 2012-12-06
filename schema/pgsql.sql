CREATE TABLE users (
    id integer,
    username character(5000),
    "password" character(1000)
);

INSERT INTO users VALUES (1, 'luther', 'blissett');
INSERT INTO users VALUES (2, 'fluffy', 'bunny');
INSERT INTO users VALUES (3, 'wu', 'ming');
INSERT INTO users VALUES (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header');
INSERT INTO users VALUES (5, NULL, 'nameisnull');

