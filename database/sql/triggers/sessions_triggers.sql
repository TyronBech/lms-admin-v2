-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [trg_sessions_after_insert:up]
DROP TRIGGER IF EXISTS `trg_sessions_after_insert`;
CREATE TRIGGER `trg_sessions_after_insert`
AFTER INSERT ON `sessions`
FOR EACH ROW
INSERT INTO audit_trail (
    record_id, source_table, field_changed, old_value, new_value, action_type, changed_by
)
SELECT
    NEW.user_id,
    'sessions',
    'login_source',
    NULL,
    NEW.login_source,
    'LOGIN',
    NEW.user_id
WHERE NEW.user_id IS NOT NULL AND NEW.login_source IS NOT NULL;
-- [end]

-- [trg_sessions_after_insert:down]
DROP TRIGGER IF EXISTS `trg_sessions_after_insert`;
-- [end]
-- [trg_sessions_after_update:up]
DROP TRIGGER IF EXISTS `trg_sessions_after_update`;
CREATE TRIGGER `trg_sessions_after_update`
AFTER UPDATE ON `sessions`
FOR EACH ROW
INSERT INTO audit_trail (
    record_id, source_table, field_changed, old_value, new_value, action_type, changed_by
)
SELECT
    NEW.user_id,
    'sessions',
    'login_source',
    NULL,
    NEW.login_source,
    'LOGIN',
    NEW.user_id
WHERE OLD.user_id IS NULL AND NEW.user_id IS NOT NULL
UNION ALL
SELECT
    OLD.user_id,
    'sessions',
    'login_source',
    OLD.login_source,
    NULL,
    'LOGOUT',
    OLD.user_id
WHERE OLD.user_id IS NOT NULL AND NEW.user_id IS NULL;
-- [end]

-- [trg_sessions_after_update:down]
DROP TRIGGER IF EXISTS `trg_sessions_after_update`;
-- [end]
