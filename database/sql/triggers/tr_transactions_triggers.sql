-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_tr_transactions_after_insert:up]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_insert`;
CREATE TRIGGER `trg_tr_transactions_after_insert`
AFTER INSERT ON `tr_transactions`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NEW.user_id IS NOT NULL THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'user_id', NULL, CAST(NEW.user_id AS CHAR), 'INSERT', actor);
    END IF;

    IF NEW.book_id IS NOT NULL THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'book_id', NULL, CAST(NEW.book_id AS CHAR), 'INSERT', actor);
    END IF;

    IF NEW.status IS NOT NULL THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'status', NULL, NEW.status, 'INSERT', actor);
    END IF;
END;
-- [end]

-- [trg_tr_transactions_after_insert:down]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_insert`;
-- [end]
-- [trg_tr_transactions_after_update:up]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_update`;
CREATE TRIGGER `trg_tr_transactions_after_update`
AFTER UPDATE ON `tr_transactions`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.status <=> NEW.status) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'status', OLD.status, NEW.status, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.penalty_status <=> NEW.penalty_status) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'penalty_status', OLD.penalty_status, NEW.penalty_status, 'UPDATE', actor);
    END IF;

    IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'tr_transactions', 'deleted_at', NULL, CAST(NEW.deleted_at AS CHAR), 'DELETE', actor);
    END IF;
END;
-- [end]

-- [trg_tr_transactions_after_update:down]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_update`;
-- [end]
-- [trg_tr_transactions_after_delete:up]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_delete`;
CREATE TRIGGER `trg_tr_transactions_after_delete`
AFTER DELETE ON `tr_transactions`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (OLD.id, 'tr_transactions', 'user_id', CAST(OLD.user_id AS CHAR), NULL, 'DELETE', actor),
        (OLD.id, 'tr_transactions', 'book_id', CAST(OLD.book_id AS CHAR), NULL, 'DELETE', actor),
        (OLD.id, 'tr_transactions', 'status', OLD.status, NULL, 'DELETE', actor),
        (OLD.id, 'tr_transactions', 'penalty_status', OLD.penalty_status, NULL, 'DELETE', actor);
END;
-- [end]

-- [trg_tr_transactions_after_delete:down]
DROP TRIGGER IF EXISTS `trg_tr_transactions_after_delete`;
-- [end]
