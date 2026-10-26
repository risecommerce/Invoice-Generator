-- Optional: only needed if any existing rows in `customers` show a blank
-- "Created" date. Run this once in phpMyAdmin (SQL tab) to backfill them.
-- Safe to run even if nothing needs fixing - it only touches NULL rows.

UPDATE customers SET created_at = NOW() WHERE created_at IS NULL;
