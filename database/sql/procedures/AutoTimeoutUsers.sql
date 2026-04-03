-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [AutoTimeoutUsers:up]
DROP PROCEDURE IF EXISTS `AutoTimeoutUsers`;
CREATE PROCEDURE `AutoTimeoutUsers`()
BEGIN
    UPDATE log_user_logs
    SET
        time_out = TIMESTAMP(CURRENT_DATE, '15:30:00'),
        remarks = 'System Generated Timeout'
    WHERE
        time_out IS NULL
        AND DATE(time_in) = CURRENT_DATE;
END;
-- [end]

-- [AutoTimeoutUsers:down]
DROP PROCEDURE IF EXISTS `AutoTimeoutUsers`;
-- [end]
