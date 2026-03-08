-- ============================================================
-- TABLAS MAESTRAS: marcas, paises, provincias, localidades, proveedores
-- ============================================================

CREATE TABLE IF NOT EXISTS `marcas` (
    `id_marca`  INT(11)      NOT NULL AUTO_INCREMENT,
    `marca`     VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_marca`),
    UNIQUE KEY `uq_marca` (`marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `paises` (
    `id_pais`   INT(11)      NOT NULL AUTO_INCREMENT,
    `pais`      VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_pais`),
    UNIQUE KEY `uq_pais` (`pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `provincias` (
    `id_provincia`  INT(11)      NOT NULL AUTO_INCREMENT,
    `id_pais`       INT(11)      NOT NULL,
    `provincia`     VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_provincia`),
    KEY `idx_provincia_pais` (`id_pais`),
    CONSTRAINT `fk_provincia_pais` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `localidades` (
    `id_localidad`  INT(11)      NOT NULL AUTO_INCREMENT,
    `id_provincia`  INT(11)      NOT NULL,
    `localidad`     VARCHAR(150) NOT NULL,
    PRIMARY KEY (`id_localidad`),
    KEY `idx_localidad_provincia` (`id_provincia`),
    CONSTRAINT `fk_localidad_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id_provincia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `proveedores` (
    `id_proveedor`  INT(11)      NOT NULL AUTO_INCREMENT,
    `cuit_cuil_dni` VARCHAR(20)  NULL DEFAULT NULL,
    `razon_social`  VARCHAR(200) NOT NULL,
    `direccion`     VARCHAR(200) NULL DEFAULT NULL,
    `id_localidad`  INT(11)      NULL DEFAULT NULL,
    `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_proveedor`),
    KEY `idx_proveedor_localidad` (`id_localidad`),
    CONSTRAINT `fk_proveedor_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
