-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [Archive_user_logs:up]
DROP PROCEDURE IF EXISTS `Archive_user_logs`;
CREATE PROCEDURE `Archive_user_logs`()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    INSERT INTO archive_user_logs (user_id, first_name, middle_name, last_name, computer_use, action, timestamp, archived_at)
    SELECT
        u.id,
        u.first_name,
        u.middle_name,
        u.last_name,
        l.computer_use,
        IFNULL(l.remarks, 'Library Visit'),
        COALESCE(l.time_out, l.time_in, NOW()),
        NOW()
    FROM log_user_logs l
    JOIN usr_users u ON u.id = l.user_id
    WHERE COALESCE(l.time_out, l.time_in, NOW()) < NOW() - INTERVAL 1 MONTH;

    DELETE FROM log_user_logs
    WHERE COALESCE(time_out, time_in, NOW()) < NOW() - INTERVAL 1 MONTH;

    COMMIT;
END;
-- [end]

-- [Archive_user_logs:down]
DROP PROCEDURE IF EXISTS `Archive_user_logs`;
-- [end]
