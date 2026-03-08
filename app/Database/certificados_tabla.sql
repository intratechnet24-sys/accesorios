-- ============================================================
-- Tabla: certificados
-- Descripcion: Certificados de vigencia para accesorios criticos
-- ============================================================

CREATE TABLE IF NOT EXISTS `certificados` (
    `id_certificado`      INT(11)      NOT NULL AUTO_INCREMENT,
    `id_componente`       INT(11)      NOT NULL,
    `numero_certificado`  VARCHAR(100) NOT NULL,
    `entidad_certificadora` VARCHAR(200) NOT NULL,
    `fecha_emision`       DATE         NOT NULL,
    `fecha_vencimiento`   DATE         NOT NULL,
    `observaciones`       TEXT         NULL DEFAULT NULL,
    `created_at`          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_certificado`),
    KEY `idx_id_componente` (`id_componente`),
    CONSTRAINT `fk_certificados_componente`
        FOREIGN KEY (`id_componente`)
        REFERENCES `componentes` (`id_componente`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
