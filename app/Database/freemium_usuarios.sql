-- ============================================================
-- MODELO FREEMIUM: Planes, Usuarios, Cuentas, Invitaciones
-- ============================================================

-- PLANES
CREATE TABLE IF NOT EXISTS `planes` (
    `id_plan`         INT(11)        NOT NULL AUTO_INCREMENT,
    `nombre`          VARCHAR(100)   NOT NULL,
    `monto`           DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    `descripcion`     TEXT           NULL,
    `funcionalidades` TEXT           NULL,
    `created_at`      DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_plan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `planes` (`nombre`, `monto`, `descripcion`, `funcionalidades`) VALUES
('Inicial', 0.00,
 'Plan gratuito para comenzar',
 'Hasta 5 equipos · Hasta 20 accesorios · 1 usuario · Soporte básico'),
('Medio', 2999.00,
 'Plan para pequeñas y medianas empresas',
 'Hasta 50 equipos · Hasta 200 accesorios · Hasta 5 usuarios · Reportes · Soporte prioritario'),
('Avanzado', 7999.00,
 'Plan completo sin límites',
 'Equipos ilimitados · Accesorios ilimitados · Usuarios ilimitados · Reportes avanzados · Soporte 24/7');

-- USUARIOS
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id_usuario`  INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre`      VARCHAR(100) NOT NULL,
    `apellido`    VARCHAR(100) NOT NULL,
    `email`       VARCHAR(200) NOT NULL,
    `username`    VARCHAR(100) NOT NULL,
    `password`    VARCHAR(255) NOT NULL,
    `foto`        VARCHAR(255) NULL DEFAULT NULL,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_usuario`),
    UNIQUE KEY `uq_email`    (`email`),
    UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- CUENTAS
CREATE TABLE IF NOT EXISTS `cuentas` (
    `id_cuenta`          INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre_cuenta`      VARCHAR(200) NOT NULL,
    `id_plan`            INT(11)      NOT NULL DEFAULT 1,
    `id_usuario_creador` INT(11)      NOT NULL,
    `created_at`         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_cuenta`),
    KEY `idx_cuenta_plan`    (`id_plan`),
    KEY `idx_cuenta_creador` (`id_usuario_creador`),
    CONSTRAINT `fk_cuenta_plan`    FOREIGN KEY (`id_plan`)            REFERENCES `planes`   (`id_plan`),
    CONSTRAINT `fk_cuenta_creador` FOREIGN KEY (`id_usuario_creador`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- RELACION USUARIO ↔ CUENTA (con rol)
CREATE TABLE IF NOT EXISTS `cuenta_usuarios` (
    `id`         INT(11)                            NOT NULL AUTO_INCREMENT,
    `id_cuenta`  INT(11)                            NOT NULL,
    `id_usuario` INT(11)                            NOT NULL,
    `rol`        ENUM('administrador','colaborador') NOT NULL DEFAULT 'colaborador',
    `created_at` DATETIME                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_cuenta_usuario` (`id_cuenta`, `id_usuario`),
    KEY `idx_cu_usuario` (`id_usuario`),
    CONSTRAINT `fk_cu_cuenta`  FOREIGN KEY (`id_cuenta`)  REFERENCES `cuentas`  (`id_cuenta`)  ON DELETE CASCADE,
    CONSTRAINT `fk_cu_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INVITACIONES
CREATE TABLE IF NOT EXISTS `invitaciones` (
    `id_invitacion` INT(11)                            NOT NULL AUTO_INCREMENT,
    `id_cuenta`     INT(11)                            NOT NULL,
    `nombre`        VARCHAR(100)                       NOT NULL,
    `apellido`      VARCHAR(100)                       NOT NULL,
    `email`         VARCHAR(200)                       NOT NULL,
    `rol`           ENUM('administrador','colaborador') NOT NULL DEFAULT 'colaborador',
    `token`         VARCHAR(64)                        NOT NULL,
    `estado`        ENUM('pendiente','aceptada','expirada') NOT NULL DEFAULT 'pendiente',
    `created_at`    DATETIME                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_invitacion`),
    UNIQUE KEY `uq_token` (`token`),
    KEY `idx_inv_cuenta` (`id_cuenta`),
    CONSTRAINT `fk_inv_cuenta` FOREIGN KEY (`id_cuenta`) REFERENCES `cuentas` (`id_cuenta`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
