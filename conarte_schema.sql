-- =========================================================
-- Base de datos: Web ConArte Construcciones
-- Proyecto de residencia profesional - Alejandro Zermeño
-- Motor: MySQL 8
-- =========================================================

CREATE DATABASE IF NOT EXISTS conarte_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE conarte_db;

-- ---------------------------------------------------------
-- Tabla: usuarios (acceso al panel de administración)
-- ---------------------------------------------------------
CREATE TABLE usuarios (
  id_usuario     INT AUTO_INCREMENT PRIMARY KEY,
  nombre         VARCHAR(100)  NOT NULL,
  correo         VARCHAR(150)  NOT NULL UNIQUE,
  contrasena     VARCHAR(255)  NOT NULL,        -- se guarda con hash (bcrypt/password_hash de PHP)
  rol            ENUM('admin', 'editor')  NOT NULL DEFAULT 'editor',
  activo         TINYINT(1)    NOT NULL DEFAULT 1,
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabla: categorias (catálogo del portafolio)
-- ---------------------------------------------------------
CREATE TABLE categorias (
  id_categoria   INT AUTO_INCREMENT PRIMARY KEY,
  nombre         VARCHAR(100)  NOT NULL UNIQUE,   -- Ej: Gobierno, Templos, Bachilleratos, Residencial, Industrial
  descripcion    VARCHAR(255)  NULL,
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabla: proyectos
-- ---------------------------------------------------------
CREATE TABLE proyectos (
  id_proyecto    INT AUTO_INCREMENT PRIMARY KEY,
  id_categoria   INT           NOT NULL,
  nombre         VARCHAR(150)  NOT NULL,
  descripcion    TEXT          NULL,
  ubicacion      VARCHAR(150)  NULL,
  fecha_proyecto DATE          NULL,
  destacado      TINYINT(1)    NOT NULL DEFAULT 0,   -- para mostrar en Inicio
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_proyecto_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabla: imagenes (galería por proyecto)
-- ---------------------------------------------------------
CREATE TABLE imagenes (
  id_imagen      INT AUTO_INCREMENT PRIMARY KEY,
  id_proyecto    INT           NOT NULL,
  ruta_archivo   VARCHAR(255)  NOT NULL,
  texto_alt      VARCHAR(150)  NULL,
  orden          INT           NOT NULL DEFAULT 0,
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_imagen_proyecto
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabla: contactos (mensajes del formulario)
-- ---------------------------------------------------------
CREATE TABLE contactos (
  id_contacto    INT AUTO_INCREMENT PRIMARY KEY,
  nombre         VARCHAR(150)  NOT NULL,
  correo         VARCHAR(150)  NOT NULL,
  telefono       VARCHAR(20)   NULL,
  mensaje        TEXT          NOT NULL,
  atendido       TINYINT(1)    NOT NULL DEFAULT 0,
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabla: chatbot_faq (preguntas frecuentes del chatbot)
-- ---------------------------------------------------------
CREATE TABLE chatbot_faq (
  id_faq         INT AUTO_INCREMENT PRIMARY KEY,
  pregunta       VARCHAR(255)  NOT NULL,
  respuesta      TEXT          NOT NULL,
  palabras_clave VARCHAR(255)  NULL,    -- lista separada por comas, usada para el matching del bot
  activo         TINYINT(1)    NOT NULL DEFAULT 1,
  creado_en      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Índices adicionales recomendados
-- ---------------------------------------------------------
CREATE INDEX idx_proyectos_categoria ON proyectos(id_categoria);
CREATE INDEX idx_imagenes_proyecto   ON imagenes(id_proyecto);
CREATE INDEX idx_contactos_atendido  ON contactos(atendido);

-- ---------------------------------------------------------
-- Datos semilla: categorías reales del portafolio de ConArte
-- (ajustadas el 07-sep-2026 tras recibir el material institucional)
-- ---------------------------------------------------------
INSERT INTO categorias (nombre, descripcion) VALUES
  ('Educativo',               'Escuelas de todos los niveles, universidad y centros de desarrollo educativo'),
  ('Gobierno y Obra Pública', 'Infraestructura urbana, drenaje, plazoletas y edificios municipales'),
  ('Residencial',             'Casas habitación, fraccionamientos y vivienda de interés social'),
  ('Industrial',              'Naves industriales y plantas de producción'),
  ('Comercial',               'Locales comerciales, franquicias y oficinas corporativas'),
  ('Institucional',           'Proyectos institucionales y de asociaciones civiles');

INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES
  ('Admin ConArte', 'admin@conarte.mx', '$2y$10$CAMBIAR_ESTE_HASH_EN_PHP', 'admin');
  -- Genera el hash real con password_hash('tu_password', PASSWORD_DEFAULT) en PHP antes de usarlo.

INSERT INTO chatbot_faq (pregunta, respuesta, palabras_clave) VALUES
  ('¿Qué tipo de proyectos realiza ConArte?', 'Realizamos obras de gobierno, templos, bachilleratos, proyectos residenciales e industriales.', 'proyectos,servicios,que hacen'),
  ('¿Cómo puedo solicitar una cotización?', 'Puedes escribirnos desde el formulario de contacto y un asesor te responderá a la brevedad.', 'cotizacion,precio,presupuesto'),
  ('¿En qué ciudades trabajan?', 'Operamos principalmente en Colima y municipios cercanos.', 'ubicacion,ciudad,donde');
