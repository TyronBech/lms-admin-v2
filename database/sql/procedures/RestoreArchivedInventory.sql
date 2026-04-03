-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [RestoreArchivedInventory:up]
DROP PROCEDURE IF EXISTS `RestoreArchivedInventory`;
CREATE PROCEDURE `RestoreArchivedInventory`(IN in_archive_id BIGINT)
BEGIN
    DECLARE book_exists INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    SELECT COUNT(*) INTO book_exists
    FROM bk_books
    WHERE id = (SELECT book_id FROM archive_inventories WHERE id = in_archive_id LIMIT 1);

    IF book_exists > 0 THEN
        INSERT INTO bk_inventories (book_id, checked_at, created_at, updated_at)
        SELECT book_id, checked_at, NOW(), NOW()
        FROM archive_inventories
        WHERE id = in_archive_id;

        DELETE FROM archive_inventories WHERE id = in_archive_id;
    END IF;

    COMMIT;
END;
-- [end]

-- [RestoreArchivedInventory:down]
DROP PROCEDURE IF EXISTS `RestoreArchivedInventory`;
-- [end]
