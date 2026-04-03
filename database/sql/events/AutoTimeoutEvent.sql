-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [AutoTimeoutEvent:up]
DROP EVENT IF EXISTS `AutoTimeoutEvent`;
CREATE EVENT `AutoTimeoutEvent` ON SCHEDULE EVERY 1 DAY STARTS '2025-06-09 17:52:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL AutoTimeoutUsers();
-- [end]

-- [AutoTimeoutEvent:down]
DROP EVENT IF EXISTS `AutoTimeoutEvent`;
-- [end]
