IF OBJECT_ID ('FindRecord') IS NOT NULL
    DROP PROCEDURE FindRecord;
GO

CREATE PROCEDURE FindRecord
@name VARCHAR(MAX)
AS
EXEC('SELECT * FROM users WHERE users.name LIKE ''' + @name + '''');
GO
