-- ============================================================
-- ALTER: equipos - reemplazar marca varchar por id_marca FK
-- ============================================================
ALTER TABLE `equipos`
    ADD COLUMN `id_marca` INT(11) NULL DEFAULT NULL AFTER `modelo`,
    ADD CONSTRAINT `fk_equipo_marca` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`) ON DELETE SET NULL;

-- ============================================================
-- ALTER: componentes - agregar id_marca e id_proveedor
-- ============================================================
ALTER TABLE `componentes`
    ADD COLUMN `id_marca`     INT(11) NULL DEFAULT NULL AFTER `lugar`,
    ADD COLUMN `id_proveedor` INT(11) NULL DEFAULT NULL AFTER `id_marca`,
    ADD CONSTRAINT `fk_componente_marca`     FOREIGN KEY (`id_marca`)     REFERENCES `marcas`      (`id_marca`)     ON DELETE SET NULL,
    ADD CONSTRAINT `fk_componente_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`)  ON DELETE SET NULL;
