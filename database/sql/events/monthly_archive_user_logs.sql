-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [monthly_archive_user_logs:up]
DROP EVENT IF EXISTS `monthly_archive_user_logs`;
CREATE EVENT `monthly_archive_user_logs` ON SCHEDULE EVERY 1 MONTH STARTS '2025-03-19 22:05:05' ON COMPLETION NOT PRESERVE ENABLE DO CALL Archive_user_logs();
-- [end]

-- [monthly_archive_user_logs:down]
DROP EVENT IF EXISTS `monthly_archive_user_logs`;
-- [end]
