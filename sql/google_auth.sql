-- sql/google_auth.sql
-- Run this in phpMyAdmin to enable Google Social Login

ALTER TABLE users ADD COLUMN google_id VARCHAR(255) DEFAULT NULL AFTER email;
ALTER TABLE users MODIFY COLUMN password_hash VARCHAR(255) DEFAULT NULL;
CREATE UNIQUE INDEX idx_google_id ON users (google_id);
