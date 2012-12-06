CREATE TABLE users (
    id int NOT NULL,
    name varchar(500) default NULL,
    surname varchar(1000) default NULL,
);

INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset');
INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny');
INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming');
INSERT INTO users (id, name, surname) VALUES (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header');
INSERT INTO users (id, name, surname) VALUES (5, NULL, 'nameisnull');

