-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_books_after_insert:up]
DROP TRIGGER IF EXISTS `trg_books_after_insert`;
CREATE TRIGGER `trg_books_after_insert`
AFTER INSERT ON `bk_books`
FOR EACH ROW
BEGIN
    UPDATE bk_categories
    SET newly_acquired = newly_acquired + 1,
        present_inventory = present_inventory + 1
    WHERE id = NEW.category_id;
END;
-- [end]

-- [trg_books_after_insert:down]
DROP TRIGGER IF EXISTS `trg_books_after_insert`;
-- [end]
-- [trg_books_after_soft_delete:up]
DROP TRIGGER IF EXISTS `trg_books_after_delete`;
DROP TRIGGER IF EXISTS `trg_books_after_soft_delete`;
CREATE TRIGGER `trg_books_after_soft_delete`
AFTER UPDATE ON `bk_books`
FOR EACH ROW
BEGIN
    IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
        -- Book was soft-deleted
        UPDATE bk_categories
        SET discarded = discarded + 1,
            present_inventory = present_inventory - 1
        WHERE id = NEW.category_id;
    ELSEIF OLD.deleted_at IS NOT NULL AND NEW.deleted_at IS NULL THEN
        -- Book was restored
        UPDATE bk_categories
        SET discarded = discarded - 1,
            present_inventory = present_inventory + 1
        WHERE id = NEW.category_id;
    ELSEIF OLD.deleted_at IS NULL AND NEW.deleted_at IS NULL AND NOT (OLD.category_id <=> NEW.category_id) THEN
        -- Book's category was changed while active; adjust present_inventory only.
        -- newly_acquired reflects books added in the current year, not category membership.
        UPDATE bk_categories
        SET present_inventory = present_inventory - 1
        WHERE id = OLD.category_id;

        UPDATE bk_categories
        SET present_inventory = present_inventory + 1
        WHERE id = NEW.category_id;
    END IF;
END;
-- [end]

-- [trg_books_after_soft_delete:down]
DROP TRIGGER IF EXISTS `trg_books_after_soft_delete`;
-- [end]
-- [trg_bk_books_after_insert:up]
DROP TRIGGER IF EXISTS `trg_bk_books_after_insert`;
CREATE TRIGGER `trg_bk_books_after_insert`
AFTER INSERT ON `bk_books`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (NEW.id, 'bk_books', 'accession', NULL, NEW.accession, 'INSERT', actor),
        (NEW.id, 'bk_books', 'title', NULL, NEW.title, 'INSERT', actor),
        (NEW.id, 'bk_books', 'category_id', NULL, CAST(NEW.category_id AS CHAR), 'INSERT', actor),
        (NEW.id, 'bk_books', 'availability_status', NULL, NEW.availability_status, 'INSERT', actor);
END;
-- [end]

-- [trg_bk_books_after_insert:down]
DROP TRIGGER IF EXISTS `trg_bk_books_after_insert`;
-- [end]
-- [trg_bk_books_after_update:up]
DROP TRIGGER IF EXISTS `trg_bk_books_after_update`;
CREATE TRIGGER `trg_bk_books_after_update`
AFTER UPDATE ON `bk_books`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.title <=> NEW.title) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'bk_books', 'title', OLD.title, NEW.title, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.category_id <=> NEW.category_id) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'bk_books', 'category_id', CAST(OLD.category_id AS CHAR), CAST(NEW.category_id AS CHAR), 'UPDATE', actor);
    END IF;

    IF NOT (OLD.availability_status <=> NEW.availability_status) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'bk_books', 'availability_status', OLD.availability_status, NEW.availability_status, 'UPDATE', actor);
    END IF;
END;
-- [end]

-- [trg_bk_books_after_update:down]
DROP TRIGGER IF EXISTS `trg_bk_books_after_update`;
-- [end]
-- [trg_bk_books_after_delete:up]
DROP TRIGGER IF EXISTS `trg_bk_books_after_delete`;
CREATE TRIGGER `trg_bk_books_after_delete`
AFTER DELETE ON `bk_books`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (OLD.id, 'bk_books', 'accession', OLD.accession, NULL, 'DELETE', actor),
        (OLD.id, 'bk_books', 'title', OLD.title, NULL, 'DELETE', actor),
        (OLD.id, 'bk_books', 'category_id', CAST(OLD.category_id AS CHAR), NULL, 'DELETE', actor);
END;
-- [end]

-- [trg_bk_books_after_delete:down]
DROP TRIGGER IF EXISTS `trg_bk_books_after_delete`;
-- [end]
