-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_after_visitor_insert:up]
DROP TRIGGER IF EXISTS `trg_after_visitor_insert`;
CREATE TRIGGER `trg_after_visitor_insert`
AFTER INSERT ON `usr_users`
FOR EACH ROW
BEGIN
    IF NEW.privilege_id = (SELECT id FROM privileges WHERE user_type = 'visitor' LIMIT 1) THEN
        INSERT INTO log_user_logs (user_id, computer_use, time_in, remarks, created_at, updated_at)
        VALUES (NEW.id, 'No', NOW(), 'Time in', NOW(), NOW());
    END IF;
END;
-- [end]

-- [trg_after_visitor_insert:down]
DROP TRIGGER IF EXISTS `trg_after_visitor_insert`;
-- [end]
-- [trg_usr_visitor_details_after_insert:up]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_insert`;
CREATE TRIGGER `trg_usr_visitor_details_after_insert`
AFTER INSERT ON `usr_visitor_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (NEW.user_id, 'usr_visitor_details', 'school_org', NULL, NEW.school_org, 'INSERT', actor),
        (NEW.user_id, 'usr_visitor_details', 'purpose', NULL, NEW.purpose, 'INSERT', actor);
END;
-- [end]

-- [trg_usr_visitor_details_after_insert:down]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_insert`;
-- [end]
-- [trg_usr_visitor_details_after_update:up]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_update`;
CREATE TRIGGER `trg_usr_visitor_details_after_update`
AFTER UPDATE ON `usr_visitor_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.school_org <=> NEW.school_org) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_visitor_details', 'school_org', OLD.school_org, NEW.school_org, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.purpose <=> NEW.purpose) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.user_id, 'usr_visitor_details', 'purpose', OLD.purpose, NEW.purpose, 'UPDATE', actor);
    END IF;
END;
-- [end]

-- [trg_usr_visitor_details_after_update:down]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_update`;
-- [end]
-- [trg_usr_visitor_details_after_delete:up]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_delete`;
CREATE TRIGGER `trg_usr_visitor_details_after_delete`
AFTER DELETE ON `usr_visitor_details`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (OLD.user_id, 'usr_visitor_details', 'school_org', OLD.school_org, NULL, 'DELETE', actor),
        (OLD.user_id, 'usr_visitor_details', 'purpose', OLD.purpose, NULL, 'DELETE', actor);
END;
-- [end]

-- [trg_usr_visitor_details_after_delete:down]
DROP TRIGGER IF EXISTS `trg_usr_visitor_details_after_delete`;
-- [end]
