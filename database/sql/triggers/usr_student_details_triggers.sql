-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_usr_student_details_after_insert:up]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_insert`;
CREATE TRIGGER `trg_usr_student_details_after_insert`
AFTER INSERT ON `usr_student_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (NEW.user_id, 'usr_student_details', 'id_number', NULL, NEW.id_number, 'INSERT', actor),
        (NEW.user_id, 'usr_student_details', 'level', NULL, NEW.level, 'INSERT', actor),
        (NEW.user_id, 'usr_student_details', 'section', NULL, NEW.section, 'INSERT', actor);
END;
-- [end]

-- [trg_usr_student_details_after_insert:down]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_insert`;
-- [end]
-- [trg_usr_student_details_after_update:up]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_update`;
CREATE TRIGGER `trg_usr_student_details_after_update`
AFTER UPDATE ON `usr_student_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.id_number <=> NEW.id_number) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_student_details', 'id_number', OLD.id_number, NEW.id_number, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.level <=> NEW.level) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_student_details', 'level', OLD.level, NEW.level, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.section <=> NEW.section) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_student_details', 'section', OLD.section, NEW.section, 'UPDATE', actor);
    END IF;
END;
-- [end]

-- [trg_usr_student_details_after_update:down]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_update`;
-- [end]
-- [trg_usr_student_details_after_delete:up]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_delete`;
CREATE TRIGGER `trg_usr_student_details_after_delete`
AFTER DELETE ON `usr_student_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (OLD.user_id, 'usr_student_details', 'id_number', OLD.id_number, NULL, 'DELETE', actor),
        (OLD.user_id, 'usr_student_details', 'level', OLD.level, NULL, 'DELETE', actor),
        (OLD.user_id, 'usr_student_details', 'section', OLD.section, NULL, 'DELETE', actor);
END;
-- [end]

-- [trg_usr_student_details_after_delete:down]
DROP TRIGGER IF EXISTS `trg_usr_student_details_after_delete`;
-- [end]
