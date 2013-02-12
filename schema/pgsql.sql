CREATE TABLE users (
    id integer,
    name character(500),
    surname character(1000)
);

INSERT INTO users VALUES (1, 'luther', 'blisset');
INSERT INTO users VALUES (2, 'fluffy', 'bunny');
INSERT INTO users VALUES (3, 'wu', 'ming');
INSERT INTO users VALUES (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header');
INSERT INTO users VALUES (5, NULL, 'nameisnull');

CREATE USER testuser WITH PASSWORD 'testpass';
GRANT SELECT ON users TO testuser;

