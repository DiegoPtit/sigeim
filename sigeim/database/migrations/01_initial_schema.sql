-- ========================================================
-- SISTEMA DE GESTIÓN DE ENCOLADO DE IMPRESIONES (SIGEIM)
-- ESQUEMA RELACIONAL COMPLETO Y NORMALIZADO
-- ========================================================

CREATE DATABASE IF NOT EXISTS `sigeim_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sigeim_db`;

-- --------------------------------------------------------
-- 1. TABLA DE ADMINISTRADORES (Módulos Admin/Cola)
-- --------------------------------------------------------
CREATE TABLE `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Usuario de acceso',
  `password` VARCHAR(255) NOT NULL COMMENT 'Hash BCRYPT de la contraseña',
  `name` VARCHAR(100) NOT NULL COMMENT 'Nombre del administrador u operador',
  `role` ENUM('superadmin', 'operador') DEFAULT 'operador' COMMENT 'Nivel de privilegios',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 2. TABLA DE DEPARTAMENTOS (Catálogo para el Dropdown)
-- --------------------------------------------------------
CREATE TABLE `departments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nombre oficial de la dirección u oficina',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 3. TABLA PADRE: TRABAJOS DE IMPRESIÓN (El Proceso / Archivo)
-- --------------------------------------------------------
CREATE TABLE `print_jobs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `document_name` VARCHAR(255) NOT NULL COMMENT 'Nombre legible del archivo',
  `file_path` VARCHAR(255) NOT NULL COMMENT 'Ruta física en la carpeta storage/',
  `file_type` VARCHAR(10) NOT NULL COMMENT 'Extensión (pdf, docx, etc)',
  `department_id` INT(11) NOT NULL COMMENT 'FK a la tabla departments',
  `status` ENUM('pendiente', 'en_cola', 'imprimiendo', 'completado', 'error', 'cancelado') DEFAULT 'pendiente',
  `total_copies_sum` INT(11) DEFAULT 0 COMMENT 'Sumatoria para agilizar métricas en el panel',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_job_department` 
    FOREIGN KEY (`department_id`) 
    REFERENCES `departments` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 4. TABLA HIJA: CONFIGURACIÓN DE COPIAS (El Grid Dinámico)
-- --------------------------------------------------------
CREATE TABLE `print_copies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `print_job_id` INT(11) NOT NULL COMMENT 'FK al documento padre',
  `quantity` INT(11) NOT NULL DEFAULT 1 COMMENT 'Cuántas de ESTE tipo',
  `color_mode` ENUM('blanco_negro', 'color') DEFAULT 'blanco_negro',
  `orientation` ENUM('vertical', 'horizontal') DEFAULT 'vertical',
  `scale` ENUM('original', 'reducida', 'agrandada') DEFAULT 'original',
  `specific_pages` VARCHAR(50) DEFAULT 'todas' COMMENT 'Ej: todas, 1-5, 10, 15',
  `notes` TEXT NULL COMMENT 'Observaciones puntuales de esta copia',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_print_job` 
    FOREIGN KEY (`print_job_id`) 
    REFERENCES `print_jobs` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- INSERCIÓN DE DATOS INICIALES (SEMILLAS)
-- ========================================================

-- Usuario inicial (Contraseña: admin123)
INSERT INTO `admins` (`username`, `password`, `name`, `role`) 
VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador de Sistemas', 'superadmin');

-- Departamentos base de la institución para poblar el dropdown (<select>)
INSERT INTO `departments` (`name`) 
VALUES 
('DESPACHO'),
('ADMINISTRACIÓN'),
('LEGALES'),
('RECURSOS HUMANOS'),
('BIENES'),
('INFORMÁTICA');