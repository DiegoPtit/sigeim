-- Migration 04: Update scale labels
USE `sigeim_db`;

-- Convert ENUM to VARCHAR temporarily to update values safely
ALTER TABLE `print_copies` MODIFY COLUMN `scale` VARCHAR(50);

-- Update existing records to new labels
UPDATE `print_copies` SET `scale` = 'original (100%)' WHERE `scale` = 'original';
UPDATE `print_copies` SET `scale` = 'reducido (-50%)' WHERE `scale` = 'reducida' OR `scale` = 'reducido';
UPDATE `print_copies` SET `scale` = 'agrandado (+50%)' WHERE `scale` = 'agrandada' OR `scale` = 'agrandado';

-- Apply new ENUM values
ALTER TABLE `print_copies` 
MODIFY COLUMN `scale` ENUM('original (100%)', 'reducido (-50%)', 'agrandado (+50%)') DEFAULT 'original (100%)';
