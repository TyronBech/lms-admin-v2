-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [ArchiveOldInventories:up]
DROP PROCEDURE IF EXISTS `ArchiveOldInventories`;
CREATE PROCEDURE `ArchiveOldInventories`()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    INSERT INTO archive_inventories (book_id, accession, call_number, title, author, remarks, checked_at)
    SELECT i.book_id, b.accession, b.call_number, b.title, b.author, b.remarks, i.checked_at
    FROM bk_inventories i
    JOIN bk_books b ON b.id = i.book_id
    WHERE i.created_at < NOW() - INTERVAL 1 YEAR;

    DELETE i
    FROM bk_inventories i
    WHERE i.created_at < NOW() - INTERVAL 1 YEAR;

    COMMIT;
END;
-- [end]

-- [ArchiveOldInventories:down]
DROP PROCEDURE IF EXISTS `ArchiveOldInventories`;
-- [end]
