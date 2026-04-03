-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_usr_users_after_insert:up]
DROP TRIGGER IF EXISTS `trg_usr_users_after_insert`;
CREATE TRIGGER `trg_usr_users_after_insert`
AFTER INSERT ON `usr_users`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
    VALUES
        (NEW.id, 'usr_users', 'rfid', NULL, NEW.rfid, 'INSERT', actor),
        (NEW.id, 'usr_users', 'privilege_id', NULL, CAST(NEW.privilege_id AS CHAR), 'INSERT', actor),
        (NEW.id, 'usr_users', 'first_name', NULL, NEW.first_name, 'INSERT', actor),
        (NEW.id, 'usr_users', 'middle_name', NULL, NEW.middle_name, 'INSERT', actor),
        (NEW.id, 'usr_users', 'last_name', NULL, NEW.last_name, 'INSERT', actor),
        (NEW.id, 'usr_users', 'suffix', NULL, NEW.suffix, 'INSERT', actor),
        (NEW.id, 'usr_users', 'gender', NULL, NEW.gender, 'INSERT', actor),
        (NEW.id, 'usr_users', 'email', NULL, NEW.email, 'INSERT', actor),
        (NEW.id, 'usr_users', 'password', NULL, NEW.password, 'INSERT', actor);
END;
-- [end]

-- [trg_usr_users_after_insert:down]
DROP TRIGGER IF EXISTS `trg_usr_users_after_insert`;
-- [end]
-- [soft_delete_user_details:up]
DROP TRIGGER IF EXISTS `soft_delete_user_details`;
CREATE TRIGGER `soft_delete_user_details`
AFTER UPDATE ON `usr_users`
FOR EACH ROW
BEGIN
    IF NEW.deleted_at IS NOT NULL THEN
        UPDATE usr_student_details SET deleted_at = NOW() WHERE user_id = NEW.id AND deleted_at IS NULL;
        UPDATE usr_visitor_details SET deleted_at = NOW() WHERE user_id = NEW.id AND deleted_at IS NULL;
        UPDATE usr_employee_details SET deleted_at = NOW() WHERE user_id = NEW.id AND deleted_at IS NULL;
    ELSEIF OLD.deleted_at IS NOT NULL AND NEW.deleted_at IS NULL THEN
        UPDATE usr_student_details SET deleted_at = NULL WHERE user_id = NEW.id AND deleted_at IS NOT NULL;
        UPDATE usr_visitor_details SET deleted_at = NULL WHERE user_id = NEW.id AND deleted_at IS NOT NULL;
        UPDATE usr_employee_details SET deleted_at = NULL WHERE user_id = NEW.id AND deleted_at IS NOT NULL;
    END IF;
END;
-- [end]

-- [soft_delete_user_details:down]
DROP TRIGGER IF EXISTS `soft_delete_user_details`;
-- [end]
-- [trg_usr_users_after_update:up]
DROP TRIGGER IF EXISTS `trg_usr_users_after_update`;
CREATE TRIGGER `trg_usr_users_after_update`
AFTER UPDATE ON `usr_users`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    IF NOT (OLD.rfid <=> NEW.rfid) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'usr_users', 'rfid', OLD.rfid, NEW.rfid, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.privilege_id <=> NEW.privilege_id) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'usr_users', 'privilege_id', CAST(OLD.privilege_id AS CHAR), CAST(NEW.privilege_id AS CHAR), 'UPDATE', actor);
    END IF;

    IF NOT (OLD.first_name <=> NEW.first_name) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'usr_users', 'first_name', OLD.first_name, NEW.first_name, 'UPDATE', actor);
    END IF;

    IF NOT (OLD.last_name <=> NEW.last_name) THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'usr_users', 'last_name', OLD.last_name, NEW.last_name, 'UPDATE', actor);
    END IF;

    IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
        INSERT INTO audit_trail (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by)
        VALUES (NEW.id, 'usr_users', 'deleted_at', NULL, CAST(NEW.deleted_at AS CHAR), 'DELETE', actor);
    END IF;
END;
-- [end]

-- [trg_usr_users_after_update:down]
DROP TRIGGER IF EXISTS `trg_usr_users_after_update`;
-- [end]
-- [trg_usr_users_after_delete:up]
DROP TRIGGER IF EXISTS `trg_usr_users_after_delete`;
CREATE TRIGGER `trg_usr_users_after_delete`
AFTER DELETE ON `usr_users`
FOR EACH ROW
BEGIN
    DECLARE actor VARCHAR(50);
    SET actor = IFNULL(@current_user_id, 'system');

    INSERT INTO audit_trail
        (record_id, source_table, field_changed, old_value, new_value, action_type, changed_by, created_at, updated_at)
    VALUES
        (OLD.id, 'usr_users', 'rfid', OLD.rfid, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'privilege_id', CAST(OLD.privilege_id AS CHAR), NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'first_name', OLD.first_name, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'middle_name', OLD.middle_name, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'last_name', OLD.last_name, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'suffix', OLD.suffix, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'gender', OLD.gender, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'email', OLD.email, NULL, 'DELETE', actor, NOW(), NOW()),
        (OLD.id, 'usr_users', 'password', OLD.password, NULL, 'DELETE', actor, NOW(), NOW());
END;
-- [end]

-- [trg_usr_users_after_delete:down]
DROP TRIGGER IF EXISTS `trg_usr_users_after_delete`;
-- [end]
