-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2024 a las 00:10:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `doctor_id`, `fecha`, `hora`) VALUES
(1, 1, 1, '2024-12-10', '10:00:00'),
(2, 2, 2, '2024-12-10', '11:00:00'),
(3, 3, 3, '2024-12-11', '09:30:00'),
(4, 4, 4, '2024-12-11', '14:00:00'),
(5, 5, 5, '2024-12-12', '16:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `especialidad_id` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`id`, `nombre`, `especialidad_id`, `activo`) VALUES
(1, 'Dr. Juan Rodríguez', 1, 1),
(2, 'Dra. María López', 2, 1),
(3, 'Dr. Carlos Martínez', 3, 1),
(4, 'Dra. Isabel García', 4, 1),
(5, 'Dr. Pedro Sánchez', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Traumatología', 'Especialidad médica dedicada al tratamiento de huesos, articulaciones y músculos'),
(2, 'Pediatría', 'Especialidad médica dedicada a la salud infantil'),
(3, 'Cardiología', 'Especialidad médica dedicada al diagnóstico y tratamiento de enfermedades del corazón'),
(4, 'Dermatología', 'Especialidad médica dedicada a las enfermedades de la piel'),
(5, 'Psiquiatría', 'Especialidad médica dedicada al diagnóstico y tratamiento de enfermedades mentales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `email`, `telefono`, `password`, `activo`) VALUES
(1, 'Juan Pérez', 'juan.perez@example.com', '1234567890', 'hashedpassword123', 1),
(2, 'Ana Gómez', 'ana.gomez@example.com', '0987654321', 'hashedpassword456', 1),
(3, 'Luis Rodríguez', 'luis.rodriguez@example.com', '1122334455', 'hashedpassword789', 1),
(4, 'Maria Fernanda', 'maria.fernanda@example.com', '9988776655', 'hashedpassword101', 1),
(5, 'Pedro Castillo', 'pedro.castillo@example.com', '5566778899', 'hashedpassword112', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cita` (`fecha`,`hora`,`doctor_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE doctores ADD COLUMN especialidad VARCHAR(255);


--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`id`);

--
-- Filtros para la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD CONSTRAINT `doctores_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`);
COMMIT;

ALTER TABLE pacientes ADD fecha_nacimiento DATE AFTER nombre;
UPDATE pacientes SET fecha_nacimiento = '1980-01-15' WHERE id = 1;
UPDATE pacientes SET fecha_nacimiento = '1990-05-20' WHERE id = 2;
UPDATE pacientes SET fecha_nacimiento = '1985-08-10' WHERE id = 3;
UPDATE pacientes SET fecha_nacimiento = '1992-03-30' WHERE id = 4;
UPDATE pacientes SET fecha_nacimiento = '1978-11-25' WHERE id = 5;

ALTER TABLE `doctores`
  ADD CONSTRAINT `fk_doctor_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE citas ADD COLUMN descripcion TEXT;

ALTER TABLE citas ADD COLUMN fecha_hora DATETIME NOT NULL;
DESCRIBE citas;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
