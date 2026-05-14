-- --------------------------------------------------------
-- 7. ADICIÓN DE CAMPO PARA IMPRESIÓN DOBLE CARA
-- --------------------------------------------------------
ALTER TABLE `print_copies` 
ADD COLUMN `is_double` TINYINT(1) DEFAULT 0 AFTER `scale`;
