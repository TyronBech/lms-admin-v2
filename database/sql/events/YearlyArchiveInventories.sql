-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [YearlyArchiveInventories:up]
DROP EVENT IF EXISTS `YearlyArchiveInventories`;
CREATE EVENT `YearlyArchiveInventories` ON SCHEDULE EVERY 1 YEAR STARTS '2025-03-21 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL ArchiveOldInventories();
-- [end]

-- [YearlyArchiveInventories:down]
DROP EVENT IF EXISTS `YearlyArchiveInventories`;
-- [end]
