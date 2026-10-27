-- =========================================================
-- Cambios estéticos solicitados por ConArte (octubre 2026)
-- Ejecutar una sola vez en phpMyAdmin (base conarte_db)
-- =========================================================

USE conarte_db;

-- Nueva categoría "Obras en proceso" (INSERT IGNORE evita error si ya existe)
INSERT IGNORE INTO categorias (nombre, descripcion) VALUES
  ('Obras en proceso', 'Obras que se encuentran actualmente en construcción');

-- Imágenes del carrusel del encabezado de la página de Inicio.
-- Más adelante se administrarán desde el panel de administración.
CREATE TABLE IF NOT EXISTS carrusel_imagenes (
  id_carrusel   INT AUTO_INCREMENT PRIMARY KEY,
  ruta_archivo  VARCHAR(255) NOT NULL,      -- relativa a public/, ej: assets/img/carrusel/obra1.jpg
  texto_alt     VARCHAR(150) NULL,
  orden         INT          NOT NULL DEFAULT 0,
  activo        TINYINT      NOT NULL DEFAULT 1,
  creado_en     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Ejemplo para registrar una imagen (descomenta y ajusta cuando tengas las fotos):
-- INSERT INTO carrusel_imagenes (ruta_archivo, texto_alt, orden) VALUES
--   ('assets/img/carrusel/obra1.jpg', 'Edificio de oficinas CMIC, Tecomán', 1),
--   ('assets/img/carrusel/obra2.jpg', 'Casa Bonsái, Colima', 2),
--   ('assets/img/carrusel/obra3.jpg', 'Nave industrial Taniart, Tecomán', 3);
