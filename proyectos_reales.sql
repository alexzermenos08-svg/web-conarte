-- =========================================================
-- Carga de proyectos reales — Portafolio ConArte Construcciones
-- Fuente: Portafolio_Empresarial_ConArTe_2025.pdf (compartido por Eduardo)
-- Fecha de carga: 07-sep-2026
--
-- Mapeo de categorías (ver categorias en conarte_schema.sql):
-- 1 = Educativo | 2 = Gobierno y Obra Pública | 3 = Residencial
-- 4 = Industrial | 5 = Comercial | 6 = Institucional
--
-- NOTA: las fechas se normalizaron al día 01 del mes reportado,
-- ya que el portafolio original solo especifica mes y año.
-- Los primeros 6 registros se marcan como destacados (destacado=1)
-- para poblar la sección de Inicio; ajusta a tu gusto.
-- =========================================================

USE conarte_db;

INSERT INTO proyectos (id_categoria, nombre, descripcion, ubicacion, fecha_proyecto, destacado) VALUES

-- ===== 2025 - 2023 (más recientes, destacados) =====
(3, 'Segunda Etapa Granja Acuícola La Noria', 'Segunda etapa de la granja acuícola, contrato privado.', 'Cerro de Ortega, Tecomán, Col.', '2025-01-01', 1),
(3, 'Ampliación y Remodelación Casa Bonsái', 'Ampliación y remodelación de casa residencial, Fracc. Puerta Paraíso.', 'Colima, Col.', '2024-04-01', 1),
(3, 'Casa de Playa Familia Sánchez', 'Construcción de casa de playa, contrato de obra privada.', 'Balneario El Real, Tecomán, Col.', '2024-01-01', 1),
(5, 'Rehabilitación Total Casino de La Feria del Limón', 'Rehabilitación total del casino de la feria, contrato de obra pública.', 'Tecomán, Col.', '2023-10-01', 1),
(5, 'Franquicia Churrería Porfirio', 'Construcción de local para franquicia de churrería.', 'Av. Pedro A. Galván, Colima, Col.', '2023-10-01', 1),
(3, 'Granja Acuícola La Noria (Primera Etapa)', 'Primera etapa de granja acuícola, contrato privado.', 'Cerro de Ortega, Tecomán, Col.', '2023-04-01', 1),

-- ===== 2023 =====
(4, 'Nave Industrial y Área de Embarque', 'Nave industrial y área de embarque para Productos Taniart S de R.L. de C.V.', 'Carretera Libre Tecomán-Armería, Tecomán, Col.', '2023-10-01', 0),
(2, 'Rehabilitación Red de Drenaje And. 6 El Chamizal', 'Rehabilitación de red de drenaje, contrato con el H. Ayuntamiento de Tecomán.', 'Tecomán, Col.', '2023-06-01', 0),

-- ===== 2022 =====
(2, 'Plazoletas El Real y Tecuanillo', 'Construcción de plazoletas de acceso a balnearios, contrato con el H. Ayuntamiento de Tecomán.', 'Balnearios El Real y Tecuanillo, Tecomán, Col.', '2022-01-01', 0),

-- ===== 2021 =====
(3, 'Casa Residencial Sr. Miguel Huerta Marmolejo', 'Proyecto y construcción de casa residencial, contrato particular.', 'Tecomán, Col.', '2021-04-01', 0),
(1, 'Rehabilitación E.P. José Juan Ortega', 'Rehabilitación de escuela primaria, contrato con INCOIFED.', 'Cerro de Ortega, Tecomán, Col.', '2021-03-01', 0),
(1, 'Rehabilitación E.P. Lino Reyes y Esc. Sec. Rafael Heredia Velasco', 'Rehabilitación de escuela primaria y secundaria, contrato con INCOIFED.', 'Tecolapa, Tecomán, Col.', '2021-02-01', 0),

-- ===== 2020 =====
(2, 'Rehabilitación de Varios CEDECOS', 'Rehabilitación de centros de desarrollo comunitario en varias colonias, contrato con el H. Ayuntamiento de Tecomán.', 'Varias colonias, Tecomán, Col.', '2020-11-01', 0),
(1, 'Rehabilitación Esc. Prim. Cuauhtémoc', 'Rehabilitación de escuela primaria, contrato con INCOIFED.', 'Colonia Unión, Tecomán, Col.', '2020-09-01', 0),
(1, 'Rehabilitación Esc. Sec. Fed. José Mora y Verduzco', 'Rehabilitación de escuela secundaria federal.', 'Cuauhtémoc, Colima, Col.', '2020-06-01', 0),
(1, 'Rehabilitación Esc. Prim. Art. 3 Constitucional', 'Rehabilitación de escuela primaria, contrato con INCOIFED.', 'Zacualpan, Comala, Col.', '2020-05-01', 0),
(1, 'Rehabilitación Sec. Fed. Octavio Paz Lozano', 'Rehabilitación de escuela secundaria federal, contrato con INCOIFED.', 'La Reserva, Villa de Álvarez, Col.', '2020-02-01', 0),

-- ===== 2019 =====
(1, 'Rehabilitación E.P. Rey Coliman', 'Rehabilitación de escuela primaria, contrato con INCOIFED.', 'Tecomán, Col.', '2019-07-01', 0),
(5, 'Edificio de Oficinas de Contacto y Capacitación CMIC', 'Construcción de edificio de oficinas para la Cámara Mexicana de la Industria de la Construcción.', 'Tecomán, Col.', '2019-07-01', 0),

-- ===== 2018 =====
(1, 'Rehabilitación Facultad de Ciencias Químicas U de C', 'Rehabilitación de facultad universitaria, contrato con la Universidad de Colima.', 'Campus Coquimatlán, Col.', '2018-12-01', 0),
(1, 'Rehabilitación Escuela Primaria Benito Juárez García', 'Rehabilitación de escuela primaria, contrato con INCOIFED.', 'Comala, Col.', '2018-03-01', 0),
(1, 'Rehabilitación Jardín de Niños Carlos Núñez Valencia', 'Rehabilitación de jardín de niños, contrato con INCOIFED.', 'Colima, Col.', '2018-02-01', 0),
(1, 'Rehabilitación Centro de Atención Múltiple Jean Piaget', 'Rehabilitación de centro de atención múltiple, contrato con INCOIFED.', 'Colima, Col.', '2018-02-01', 0),

-- ===== 2017 =====
(2, 'Construcción EMSAD No. 7 "Dr. Miguel Galindo"', 'Construcción de bachillerato EMSAD, contrato con INCOIFED.', 'Agua Salada, Minatitlán, Col.', '2017-01-01', 0),

-- ===== 2016 =====
(2, 'Rehabilitación Red de Drenaje Colonia Unión', 'Rehabilitación de red de drenaje, contrato con el H. Ayuntamiento de Tecomán.', 'Tecomán, Col.', '2016-09-01', 0),
(6, 'Rehabilitación del Paraninfo Universitario', 'Rehabilitación de servicios sanitarios del paraninfo, contrato con la Secretaría de Cultura del Estado.', 'Colima, Col.', '2016-09-01', 0),
(4, 'Construcción de Túneles de Secado de Materia Prima (SUHM)', 'Túneles de secado para la Planta Productora de Sustratos Hidropónicos, contrato privado.', 'Colonia Valle Querido, Tecomán, Col.', '2016-02-01', 0),
(1, 'Remodelación y Rehabilitación E.P. Marina Nacional', 'Remodelación y rehabilitación de escuela primaria, contrato con INCOIFED.', 'Manzanillo, Col.', '2016-01-01', 0),

-- ===== 2015 =====
(1, 'Reparación de Laboratorio y Remodelación Sec. Gregorio Torres Quintero', 'Reparación de laboratorio y remodelación de servicios sanitarios, contrato con INCOIFED.', 'Tecomán, Col.', '2015-07-01', 0),
(1, 'Reparaciones y Remodelación Edificio "G" E.P. Margarita Maza de Juárez', 'Reparaciones y remodelación de edificio escolar.', 'Colonia Bayardo, Tecomán, Col.', '2015-06-01', 0),
(4, 'Taller de Mantenimiento, Almacén y Laboratorio de Pruebas (SUHM)', 'Construcción de taller y laboratorio dentro de la Planta Productora de Sustratos Hidropónicos, contrato privado.', 'Colonia Valle Querido, Tecomán, Col.', '2015-05-01', 0),
(1, 'Reparación y Remodelación Telesecundaria Sor Juana Inés de la Cruz', 'Reparación y remodelación de servicios sanitarios, mobiliario y accesibilidad.', 'Coalatilla, Armería, Col.', '2015-04-01', 0),

-- ===== 2014 =====
(1, 'Reparaciones y Remodelación Jardín de Niños Emiliano Zapata', 'Reparaciones y remodelación de jardín de niños.', 'Caleras, Tecomán, Col.', '2014-10-01', 0),
(4, 'Ampliación Productora y Comercializadora de Sustratos Hidropónicos', 'Ampliación de comedor, fosa séptica y oficinas, contrato privado.', 'Colonia Valle Querido, Tecomán, Col.', '2014-08-01', 0),
(1, 'Construcción Obra E.P. Ramón G. Bonfil', 'Construcción de dirección, cocina fría y remodelación de servicios sanitarios.', 'Colonia Elva Cecilia Vega, Tecomán, Col.', '2014-08-01', 0),
(1, 'Construcción Obra Telesecundaria Rafael Heredia Velasco', 'Revisión de seguridad estructural y condiciones generales de funcionamiento.', 'Tecolapa, Tecomán, Col.', '2014-06-01', 0),
(1, 'Construcción Obra E.P. Patricio Gabriel Araujo Vázquez', 'Construcción de aula didáctica más obra exterior.', 'Colonia Villas Buganvilias, Villa de Álvarez, Col.', '2014-05-01', 0),

-- ===== 2013 =====
(1, 'Construcción Obra CONALEP 313', 'Construcción de edificio "A": finanzas, servicios escolares y pórtico de ingreso.', 'Colonia Villas del Real, Tecomán, Col.', '2013-12-01', 0),
(1, 'Construcción Obra Esc. Sec. Tec. No. 6 "Moisés Sáenz Garza"', 'Construcción de edificio "H", taller de mecánica automotriz más obra exterior.', 'Colonia Loma Bonita, Villa de Álvarez, Col.', '2013-12-01', 0),
(1, 'Construcción Obra E.P. Lázaro Cárdenas del Río', 'Seguridad estructural y servicios sanitarios.', 'Colonia Griselda Álvarez, Tecomán, Col.', '2013-12-01', 0),
(1, 'Construcción Obra E.P. Juan de la Barrera', 'Seguridad estructural y servicios sanitarios.', 'Colonia Amalia Solórzano, Tecomán, Col.', '2013-12-01', 0),
(1, 'Construcción Obra E.P. Miguel Hidalgo y Costilla', 'Seguridad estructural y servicios sanitarios.', 'Tecomán, Col.', '2013-12-01', 0),
(3, 'Casa Habitación Calle Tokio', 'Proyecto y construcción de casa habitación, contrato particular.', 'Colonia Real Santa Fe, Villa de Álvarez, Col.', '2013-01-01', 0),

-- ===== 2012 =====
(1, 'Construcción Centro de Desarrollo Educativo', 'Construcción de edificio administrativo más obra exterior.', 'Colonia Real del Bosque, Tecomán, Col.', '2012-01-01', 0),
(6, 'Banco de Germoplasma y Colección de Insectos', 'Proyecto y construcción para el Centro Nacional de Referencia de Control Biológico (CESAVECOL).', 'Tecomán, Col.', '2012-01-01', 0),
(5, 'Locales Comerciales Colonia Centro', 'Proyecto y construcción de locales comerciales, contrato particular.', 'Calle Reforma, Tecomán, Col.', '2012-01-01', 0),

-- ===== 2011 =====
(1, 'Cuarto de Máquinas Sistema de Riego', 'Cuarto de máquinas para sistema de riego, sub-contrato particular con la Universidad de Colima.', 'Campus Tecomán, Col.', '2012-01-01', 0),
(4, 'Primera Etapa Planta Productora de Sustratos Hidropónicos', 'Proyecto y construcción de la primera etapa de la planta, contrato particular.', 'Tecomán, Col.', '2011-01-01', 0),
(2, 'Set Didáctico para Radio y Televisión', 'Construcción de set didáctico, contrato con la SEP.', 'Parque de la Piedra Lisa, Colima, Col.', '2011-01-01', 0),
(1, 'Construcción Aula Didáctica E.P. Jesús Silverio Cavazos Ceballos', 'Construcción de aula didáctica más obra exterior, contrato con INCOIFED.', 'Colonia San Ignacio, Tecomán, Col.', '2011-01-01', 0),
(6, 'Laboratorio de Biología Molecular CNRCB', 'Proyecto y construcción de laboratorio para el Centro Nacional de Referencia de Control Biológico (CESAVECOL).', 'Tecomán, Col.', '2011-01-01', 0),

-- ===== 2010 =====
(1, 'Construcción de 2 Aulas Didácticas', 'Aulas didácticas más servicios sanitarios, dirección, bodega y patio cívico, contrato con INCOIFED.', 'Colonia Santa Elena, Tecomán, Col.', '2010-01-01', 0),
(3, 'Casa Habitación Familia Gutiérrez Sánchez', 'Proyecto y construcción de casa habitación, contrato particular.', 'Tecomán, Col.', '2010-01-01', 0),
(2, 'Adecuaciones en Ex Mercado de Quesería', 'Adecuaciones para Centro Integral de Convivencia, contrato con SEDUR.', 'Quesería, Colima, Col.', '2010-01-01', 0),
(2, 'Rehabilitación Foro al Aire Libre Casa de la Cultura', 'Rehabilitación y mejoramiento del foro al aire libre, contrato con PAICE.', 'Colima, Col.', '2010-01-01', 0),
(2, 'Rehabilitación Foro al Aire Libre Parque el Rodeo', 'Rehabilitación y mejoramiento del foro al aire libre, contrato con PAICE.', 'Colima, Col.', '2010-01-01', 0),
(1, 'Construcción "Cámara Gessel" Escuela de Mercadotecnia', 'Construcción de cámara Gessel en campus central de la Universidad de Colima.', 'Colima, Col.', '2010-01-01', 0),
(2, 'Remodelación Laboratorios SENASICA', 'Remodelación de laboratorios del Servicio Nacional de Sanidad, Inocuidad y Calidad Agroalimentaria, contrato de obra pública.', 'Tecomán, Col.', '2010-01-01', 0);
