-- Run this in phpMyAdmin (SQL tab) on the invoice_generator database,
-- AFTER you've already created the users and invoices tables.

ALTER TABLE invoices
  ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Open' AFTER po_number,
  ADD COLUMN deleted_at DATETIME NULL DEFAULT NULL AFTER created_at;

-- Helpful index for the dashboard queries (per-user, non-deleted invoices)
CREATE INDEX idx_invoices_user_deleted ON invoices (user_id, deleted_at);
