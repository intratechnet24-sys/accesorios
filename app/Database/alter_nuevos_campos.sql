-- ============================================================
-- Nuevos campos para tabla equipos (vehiculos)
-- ============================================================
ALTER TABLE `equipos`
    ADD COLUMN `dominio`              VARCHAR(20)  NULL DEFAULT NULL AFTER `modelo`,
    ADD COLUMN `numero_serie`         VARCHAR(100) NULL DEFAULT NULL AFTER `dominio`,
    ADD COLUMN `fecha_garantia`       DATE         NULL DEFAULT NULL AFTER `numero_serie`,
    ADD COLUMN `descripcion_tecnica`  TEXT         NULL DEFAULT NULL AFTER `fecha_garantia`,
    ADD COLUMN `fecha_ingreso`        DATE         NULL DEFAULT NULL AFTER `descripcion_tecnica`;

-- ============================================================
-- Nuevos campos para tabla componentes (accesorios)
-- ============================================================
ALTER TABLE `componentes`
    ADD COLUMN `codigo_trazabilidad`  VARCHAR(100) NULL DEFAULT NULL AFTER `seccion`,
    ADD COLUMN `lugar`                VARCHAR(150) NULL DEFAULT NULL AFTER `codigo_trazabilidad`;
