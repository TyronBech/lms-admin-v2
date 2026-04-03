-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [update_summary_matrix:up]
DROP PROCEDURE IF EXISTS `update_summary_matrix`;
CREATE PROCEDURE `update_summary_matrix`()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    INSERT INTO archive_categories (
        category_id, legend, name, previous_inventory, newly_acquired, discarded, present_inventory, archived_at
    )
    SELECT
        id, legend, name, previous_inventory, newly_acquired, discarded, present_inventory, NOW()
    FROM bk_categories;

    UPDATE bk_categories
    SET previous_inventory = present_inventory,
        newly_acquired = 0,
        discarded = 0;

    COMMIT;
END;
-- [end]

-- [update_summary_matrix:down]
DROP PROCEDURE IF EXISTS `update_summary_matrix`;
-- [end]
