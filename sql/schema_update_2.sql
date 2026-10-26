-- Run this in phpMyAdmin (SQL tab) on the invoice_generator database,
-- after schema_update.sql has already been applied.

CREATE TABLE invoice_sends (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  user_id INT NOT NULL,
  recipient_email VARCHAR(150) NOT NULL,
  recipient_name VARCHAR(150),
  message TEXT,
  view_token VARCHAR(64) NOT NULL UNIQUE,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (invoice_id) REFERENCES invoices(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
