-- Run this in phpMyAdmin (SQL tab) on the invoice_generator database,
-- after schema_update_3.sql has already been applied.

ALTER TABLE customers
  ADD COLUMN bill_to TEXT NULL AFTER email,
  ADD COLUMN ship_to TEXT NULL AFTER bill_to;
