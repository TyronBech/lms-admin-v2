-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [restore_user_logs:up]
DROP PROCEDURE IF EXISTS `restore_user_logs`;
CREATE PROCEDURE `restore_user_logs`(IN restore_date DATE)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    INSERT INTO log_user_logs (user_id, computer_use, time_in, time_out, remarks, created_at, updated_at)
    SELECT
        a.user_id,
        a.computer_use,
        a.timestamp,
        a.timestamp,
        a.action,
        NOW(),
        NOW()
    FROM archive_user_logs a
    WHERE DATE(a.timestamp) = restore_date
      AND a.user_id IS NOT NULL;

    DELETE FROM archive_user_logs WHERE DATE(timestamp) = restore_date;

    COMMIT;
END;
-- [end]

-- [restore_user_logs:down]
DROP PROCEDURE IF EXISTS `restore_user_logs`;
-- [end]
