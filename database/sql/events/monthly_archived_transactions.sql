-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [monthly_archived_transactions:up]
DROP EVENT IF EXISTS `monthly_archived_transactions`;
CREATE EVENT `monthly_archived_transactions` ON SCHEDULE EVERY 1 MONTH STARTS '2025-05-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL archive_transactions();
-- [end]

-- [monthly_archived_transactions:down]
DROP EVENT IF EXISTS `monthly_archived_transactions`;
-- [end]
