-- Source-of-truth SQL for migration-managed database objects.
-- Sections are loaded by App\\Support\\MigrationSqlFile.

-- [mark_transactions_overdue:up]
DROP EVENT IF EXISTS `mark_transactions_overdue`;
CREATE EVENT `mark_transactions_overdue` ON SCHEDULE EVERY 1 MINUTE STARTS '2025-05-11 09:51:36' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE tr_transactions SET status = 'Overdue', penalty_status = 'Unpaid' WHERE due_date < CURDATE() AND return_date IS NULL AND status = 'Borrowed';
-- [end]

-- [mark_transactions_overdue:down]
DROP EVENT IF EXISTS `mark_transactions_overdue`;
-- [end]
