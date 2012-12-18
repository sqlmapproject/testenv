CREATE DATABASE testdb
GO

USE testdb
GO

CREATE TABLE users (
    id INTEGER NOT NULL,
    name VARCHAR(500) DEFAULT NULL NULL,
    surname VARCHAR(1000) DEFAULT NULL NULL
)
GO

INSERT INTO users (id, name, surname) VALUES (1, 'luther', 'blisset')
GO
INSERT INTO users (id, name, surname) VALUES (2, 'fluffy', 'bunny')
GO
INSERT INTO users (id, name, surname) VALUES (3, 'wu', 'ming')
GO
INSERT INTO users (id, name, surname) VALUES (4, 'sqlmap/1.0-dev (http://sqlmap.org)', 'user agent header')
GO
INSERT INTO users (id, name, surname) VALUES (5, NULL, 'nameisnull')
GO
