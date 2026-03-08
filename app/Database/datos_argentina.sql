-- ============================================================
-- DATOS: Argentina - Pais, Provincias y Localidades principales
-- ============================================================

-- PAIS
INSERT INTO `paises` (`id_pais`, `pais`) VALUES (1, 'Argentina');

-- ------------------------------------------------------------
-- PROVINCIAS (24)
-- ------------------------------------------------------------
INSERT INTO `provincias` (`id_provincia`, `id_pais`, `provincia`) VALUES
(1,  1, 'Buenos Aires'),
(2,  1, 'Catamarca'),
(3,  1, 'Chaco'),
(4,  1, 'Chubut'),
(5,  1, 'Ciudad Autónoma de Buenos Aires'),
(6,  1, 'Córdoba'),
(7,  1, 'Corrientes'),
(8,  1, 'Entre Ríos'),
(9,  1, 'Formosa'),
(10, 1, 'Jujuy'),
(11, 1, 'La Pampa'),
(12, 1, 'La Rioja'),
(13, 1, 'Mendoza'),
(14, 1, 'Misiones'),
(15, 1, 'Neuquén'),
(16, 1, 'Río Negro'),
(17, 1, 'Salta'),
(18, 1, 'San Juan'),
(19, 1, 'San Luis'),
(20, 1, 'Santa Cruz'),
(21, 1, 'Santa Fe'),
(22, 1, 'Santiago del Estero'),
(23, 1, 'Tierra del Fuego'),
(24, 1, 'Tucumán');

-- ------------------------------------------------------------
-- LOCALIDADES PRINCIPALES POR PROVINCIA
-- ------------------------------------------------------------

-- Buenos Aires (id_provincia=1)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(1,'La Plata'),(1,'Mar del Plata'),(1,'Bahía Blanca'),(1,'Quilmes'),(1,'Lanús'),
(1,'Lomas de Zamora'),(1,'San Isidro'),(1,'Morón'),(1,'Tigre'),(1,'Vicente López'),
(1,'General San Martín'),(1,'Tres de Febrero'),(1,'Florencio Varela'),(1,'Berazategui'),
(1,'Almirante Brown'),(1,'Merlo'),(1,'Moreno'),(1,'La Matanza'),(1,'San Justo'),
(1,'Pergamino'),(1,'Tandil'),(1,'Junín'),(1,'Olavarría'),(1,'Necochea'),
(1,'San Nicolás de los Arroyos'),(1,'Campana'),(1,'Zárate'),(1,'Luján'),
(1,'Mercedes'),(1,'Azul'),(1,'Chivilcoy'),(1,'Coronel Suárez'),(1,'Pilar'),
(1,'San Fernando'),(1,'Escobar'),(1,'Bragado'),(1,'Pehuajó'),(1,'9 de Julio'),
(1,'Trenque Lauquen'),(1,'Dolores'),(1,'Chascomús'),(1,'Lobos'),(1,'Bolívar');

-- Catamarca (id_provincia=2)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(2,'San Fernando del Valle de Catamarca'),(2,'San Isidro'),(2,'Santa Rosa'),
(2,'Andalgalá'),(2,'Belén'),(2,'Tinogasta'),(2,'Capayán'),(2,'Recreo'),
(2,'Huillapima'),(2,'Fray Mamerto Esquiú');

-- Chaco (id_provincia=3)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(3,'Resistencia'),(3,'Barranqueras'),(3,'Fontana'),(3,'Presidencia Roque Sáenz Peña'),
(3,'Villa Ángela'),(3,'Charata'),(3,'General Pinedo'),(3,'Las Breñas'),
(3,'Quitilipi'),(3,'Puerto Tirol'),(3,'Campo Largo');

-- Chubut (id_provincia=4)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(4,'Rawson'),(4,'Comodoro Rivadavia'),(4,'Trelew'),(4,'Puerto Madryn'),(4,'Esquel'),
(4,'Río Gallegos'),(4,'Sarmiento'),(4,'Gaiman'),(4,'Dolavon'),(4,'Rada Tilly');

-- CABA (id_provincia=5)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(5,'Buenos Aires'),(5,'Palermo'),(5,'Belgrano'),(5,'Caballito'),(5,'San Telmo'),
(5,'Recoleta'),(5,'Flores'),(5,'Villa Urquiza'),(5,'Almagro'),(5,'Boedo'),
(5,'Parque Patricios'),(5,'La Boca'),(5,'Monserrat'),(5,'San Nicolás'),
(5,'Puerto Madero'),(5,'Retiro'),(5,'Villa Crespo'),(5,'Chacarita'),
(5,'Devoto'),(5,'Saavedra');

-- Córdoba (id_provincia=6)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(6,'Córdoba'),(6,'Villa Carlos Paz'),(6,'Río Cuarto'),(6,'San Francisco'),
(6,'Villa María'),(6,'Alta Gracia'),(6,'Cosquín'),(6,'La Falda'),(6,'Cruz del Eje'),
(6,'Río Tercero'),(6,'Marcos Juárez'),(6,'Bell Ville'),(6,'Jesús María'),
(6,'Unquillo'),(6,'Río Ceballos'),(6,'Oncativo'),(6,'Villa del Totoral'),
(6,'Leones'),(6,'Laboulaye'),(6,'Arroyito');

-- Corrientes (id_provincia=7)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(7,'Corrientes'),(7,'Goya'),(7,'Paso de los Libres'),(7,'Curuzú Cuatiá'),
(7,'Mercedes'),(7,'Bella Vista'),(7,'Santo Tomé'),(7,'Ituzaingó'),
(7,'Esquina'),(7,'Monte Caseros');

-- Entre Ríos (id_provincia=8)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(8,'Paraná'),(8,'Concordia'),(8,'Gualeguaychú'),(8,'Concepción del Uruguay'),
(8,'Gualeguay'),(8,'Villaguay'),(8,'La Paz'),(8,'Federación'),(8,'Colón'),
(8,'Victoria'),(8,'Diamante'),(8,'Rosario del Tala');

-- Formosa (id_provincia=9)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(9,'Formosa'),(9,'Clorinda'),(9,'Pirané'),(9,'General Mosconi'),(9,'Las Lomitas'),
(9,'Ibarreta'),(9,'Ingeniero Juárez'),(9,'El Colorado');

-- Jujuy (id_provincia=10)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(10,'San Salvador de Jujuy'),(10,'San Pedro de Jujuy'),(10,'Palpalá'),(10,'Libertador General San Martín'),
(10,'Perico'),(10,'Tilcara'),(10,'Humahuaca'),(10,'La Quiaca'),(10,'Abra Pampa'),
(10,'Fraile Pintado');

-- La Pampa (id_provincia=11)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(11,'Santa Rosa'),(11,'General Pico'),(11,'Toay'),(11,'Realicó'),(11,'Eduardo Castex'),
(11,'General Acha'),(11,'Victorica'),(11,'Guatraché'),(11,'Catriló'),(11,'25 de Mayo');

-- La Rioja (id_provincia=12)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(12,'La Rioja'),(12,'Chilecito'),(12,'Aimogasta'),(12,'Chamical'),(12,'Chepes'),
(12,'Vinchina'),(12,'Villa Unión'),(12,'Famatina'),(12,'Nonogasta');

-- Mendoza (id_provincia=13)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(13,'Mendoza'),(13,'San Rafael'),(13,'Godoy Cruz'),(13,'Las Heras'),(13,'Maipú'),
(13,'Luján de Cuyo'),(13,'Guaymallén'),(13,'General Alvear'),(13,'Rivadavia'),
(13,'Junín'),(13,'Malargüe'),(13,'Tupungato'),(13,'La Paz'),(13,'San Martín');

-- Misiones (id_provincia=14)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(14,'Posadas'),(14,'Oberá'),(14,'Eldorado'),(14,'Puerto Iguazú'),(14,'Apóstoles'),
(14,'Leandro N. Alem'),(14,'Jardín América'),(14,'San Vicente'),(14,'Aristóbulo del Valle'),
(14,'Montecarlo'),(14,'Campo Grande'),(14,'Puerto Rico');

-- Neuquén (id_provincia=15)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(15,'Neuquén'),(15,'Cipolletti'),(15,'Zapala'),(15,'Cutral-Có'),(15,'Plaza Huincul'),
(15,'San Martín de los Andes'),(15,'Villa La Angostura'),(15,'Junín de los Andes'),
(15,'Centenario'),(15,'Plottier'),(15,'Chos Malal'),(15,'Rincón de los Sauces');

-- Río Negro (id_provincia=16)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(16,'Viedma'),(16,'San Carlos de Bariloche'),(16,'General Roca'),(16,'Cipolletti'),
(16,'Allen'),(16,'Ingeniero Jacobacci'),(16,'El Bolsón'),(16,'Cinco Saltos'),
(16,'Catriel'),(16,'Las Grutas'),(16,'Sierra Grande'),(16,'Choele Choel');

-- Salta (id_provincia=17)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(17,'Salta'),(17,'San Ramón de la Nueva Orán'),(17,'Tartagal'),(17,'General Güemes'),
(17,'Embarcación'),(17,'Metán'),(17,'Cafayate'),(17,'Rosario de la Frontera'),
(17,'Rivadavia'),(17,'Salvador Mazza'),(17,'Aguaray'),(17,'Joaquín V. González');

-- San Juan (id_provincia=18)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(18,'San Juan'),(18,'Rivadavia'),(18,'Caucete'),(18,'Santa Lucía'),(18,'Pocito'),
(18,'Rawson'),(18,'Chimbas'),(18,'9 de Julio'),(18,'Albardón'),(18,'Iglesia');

-- San Luis (id_provincia=19)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(19,'San Luis'),(19,'Villa Mercedes'),(19,'Merlo'),(19,'Río Cuarto'),(19,'Concarán'),
(19,'La Toma'),(19,'Arizona'),(19,'Juan Martín de Pueyrredón'),(19,'Alto Pelado');

-- Santa Cruz (id_provincia=20)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(20,'Río Gallegos'),(20,'Caleta Olivia'),(20,'Pico Truncado'),(20,'Las Heras'),
(20,'Puerto Deseado'),(20,'Perito Moreno'),(20,'El Calafate'),(20,'El Chaltén'),
(20,'Los Antiguos'),(20,'Puerto San Julián');

-- Santa Fe (id_provincia=21)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(21,'Santa Fe'),(21,'Rosario'),(21,'Rafaela'),(21,'Venado Tuerto'),(21,'Villa Constitución'),
(21,'San Lorenzo'),(21,'Reconquista'),(21,'Esperanza'),(21,'Casilda'),(21,'Cañada de Gómez'),
(21,'Firmat'),(21,'Rufino'),(21,'Vera'),(21,'Santo Tomé'),(21,'Gálvez'),
(21,'Sunchales'),(21,'Villada'),(21,'Las Rosas'),(21,'San Jorge'),(21,'Arroyo Seco');

-- Santiago del Estero (id_provincia=22)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(22,'Santiago del Estero'),(22,'La Banda'),(22,'Termas de Río Hondo'),(22,'Frías'),
(22,'Añatuya'),(22,'Loreto'),(22,'Clodomira'),(22,'Suncho Corral'),(22,'Villa Atamisqui'),
(22,'Quimilí'),(22,'Monte Quemado');

-- Tierra del Fuego (id_provincia=23)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(23,'Ushuaia'),(23,'Río Grande'),(23,'Tolhuin'),(23,'Puerto Almanza');

-- Tucumán (id_provincia=24)
INSERT INTO `localidades` (`id_provincia`, `localidad`) VALUES
(24,'San Miguel de Tucumán'),(24,'Tafí Viejo'),(24,'Concepción'),(24,'Yerba Buena'),
(24,'Banda del Río Salí'),(24,'Famailla'),(24,'Monteros'),(24,'Aguilares'),
(24,'Lules'),(24,'Alderetes'),(24,'Bella Vista'),(24,'Simoca'),
(24,'Graneros'),(24,'Juan Bautista Alberdi'),(24,'Chicligasta');

-- ------------------------------------------------------------
-- MARCAS INICIALES (pueden agregarse mas desde el CRUD)
-- ------------------------------------------------------------
INSERT INTO `marcas` (`marca`) VALUES
('Ford'),('Toyota'),('Volkswagen'),('Chevrolet'),('Renault'),('Peugeot'),
('Fiat'),('Citroen'),('Honda'),('Nissan'),('Hyundai'),('Kia'),
('Mercedez-Benz'),('Volvo'),('Scania'),('Iveco'),('Man'),('DAF'),
('Caterpillar'),('John Deere'),('Komatsu'),('Bosch'),('Continental'),
('Michelin'),('Bridgestone'),('Goodyear'),('Pirelli'),('Firestone'),
('Exide'),('Varta'),('Yuasa'),('Banner'),('Delphi'),('NGK'),
('Genérico'),('Sin Marca');
