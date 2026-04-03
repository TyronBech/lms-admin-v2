-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_usr_employee_details_after_insert:up]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_insert`;
CREATE TRIGGER `trg_usr_employee_details_after_insert`
AFTER INSERT ON `usr_employee_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (NEW.user_id, 'usr_employee_details', 'employee_id', NULL, NEW.employee_id, 'INSERT', actor),
        (NEW.user_id, 'usr_employee_details', 'employee_role', NULL, NEW.employee_role, 'INSERT', actor);
END;
-- [end]

-- [trg_usr_employee_details_after_insert:down]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_insert`;
-- [end]
-- [trg_usr_employee_details_after_update:up]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_update`;
CREATE TRIGGER `trg_usr_employee_details_after_update`
AFTER UPDATE ON `usr_employee_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.employee_id <=> NEW.employee_id) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_employee_details', 'employee_id', OLD.employee_id, NEW.employee_id, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.employee_role <=> NEW.employee_role) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_employee_details', 'employee_role', OLD.employee_role, NEW.employee_role, 'UPDATE', actor);
    END IF;
END;
-- [end]

-- [trg_usr_employee_details_after_update:down]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_update`;
-- [end]
-- [trg_usr_employee_details_after_delete:up]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_delete`;
CREATE TRIGGER `trg_usr_employee_details_after_delete`
AFTER DELETE ON `usr_employee_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (OLD.user_id, 'usr_employee_details', 'employee_id', OLD.employee_id, NULL, 'DELETE', actor),
        (OLD.user_id, 'usr_employee_details', 'employee_role', OLD.employee_role, NULL, 'DELETE', actor);
END;
-- [end]

-- [trg_usr_employee_details_after_delete:down]
DROP TRIGGER IF EXISTS `trg_usr_employee_details_after_delete`;
-- [end]
