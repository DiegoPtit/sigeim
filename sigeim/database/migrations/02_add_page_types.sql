-- --------------------------------------------------------
-- 5. TABLA DE TIPOS DE PÁGINA (PAPEL)
-- --------------------------------------------------------
CREATE TABLE `page_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Nombre del tipo de papel (Carta, Oficio, etc)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserción de tipos de página comunes
INSERT INTO `page_types` (`name`) VALUES ('Carta'), ('Oficio'), ('A4'), ('Sobre');

-- --------------------------------------------------------
-- 6. ACTUALIZACIÓN DE TABLA PRINT_COPIES
-- --------------------------------------------------------
ALTER TABLE `print_copies` 
ADD COLUMN `page_type` VARCHAR(50) DEFAULT 'Carta' AFTER `quantity`;
