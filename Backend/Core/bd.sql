DROP DATABASE IF EXISTS educenter;
CREATE DATABASE IF NOT EXISTS `educenter` DEFAULT CHARACTER SET latin1;

CREATE USER IF NOT EXISTS 'new_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'new_user'@'localhost';
FLUSH PRIVILEGES;

USE `educenter`;
DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `descripcion_rol` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `borrado_logico` int NOT NULL DEFAULT '0',
  PRIMARY KEY(id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `dni` varchar(60) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellidos_usuario` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` int NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `fecha_nac` date NOT NULL,
  `borrado_logico` int NOT NULL DEFAULT '0',
  PRIMARY KEY(dni),
  FOREIGN KEY(id_rol) REFERENCES rol(id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `logattributeexception`;

CREATE TABLE `logattributeexception` (
  `usuario` varchar(29) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `funcionalidad` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `accion` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `codigo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `mensaje` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `tiempo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `logexcepcionaccion`;

CREATE TABLE `logexcepcionaccion` (
  `usuario` varchar(29) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `funcionalidad` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `accion` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `codigo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `mensaje` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `tiempo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `funcionalidad`;

CREATE TABLE `funcionalidad` (
  `id_funcionalidad` int NOT NULL AUTO_INCREMENT,
  `nombre_funcionalidad` varchar(48) NOT NULL,
  `descripcion_funcionalidad` varchar(200) NOT NULL,
  PRIMARY KEY(id_funcionalidad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `accion`;

CREATE TABLE `accion` (
  `id_accion` int NOT NULL AUTO_INCREMENT,
  `nombre_accion` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `descripcion_accion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY(id_accion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `accion_funcionalidad`;

CREATE TABLE `accion_funcionalidad` (
  `id_accion` int NOT NULL,
  `id_funcionalidad` int NOT NULL,
  PRIMARY KEY(id_accion, id_funcionalidad),
  FOREIGN KEY(id_accion) REFERENCES accion(id_accion),
  FOREIGN KEY(id_funcionalidad) REFERENCES funcionalidad(id_funcionalidad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `rol_accion_funcionalidad`;

CREATE TABLE `rol_accion_funcionalidad` (
  `id_rol` int NOT NULL,
  `id_accion` int NOT NULL,
  `id_funcionalidad` int NOT NULL,
  PRIMARY KEY(id_rol, id_accion, id_funcionalidad),
  FOREIGN KEY(id_rol) REFERENCES rol(id_rol),
  FOREIGN KEY(id_accion) REFERENCES accion(id_accion),
  FOREIGN KEY(id_funcionalidad) REFERENCES funcionalidad(id_funcionalidad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `curso_academico`;

CREATE TABLE `curso_academico` (
  `id_curso_academico` int NOT NULL AUTO_INCREMENT,
  `nombre_curso_academico` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY(id_curso_academico)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `materia`;

CREATE TABLE `materia` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nombre_materia` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `creditos` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `dni` varchar(60),
  `id_curso_academico` int NOT NULL,
  PRIMARY KEY(id_materia),
  FOREIGN KEY(dni) REFERENCES usuario(dni),
  FOREIGN KEY(id_curso_academico) REFERENCES curso_academico(id_curso_academico)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `materia_solicitud`;

CREATE TABLE `materia_solicitud` (
  `id_materia` int NOT NULL,
  `dni` varchar(60) NOT NULL,
  `secundario` varchar(11) DEFAULT NULL,
  PRIMARY KEY(id_materia, dni),
  FOREIGN KEY(dni) REFERENCES usuario(dni),
  FOREIGN KEY(id_materia) REFERENCES materia(id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `materia_alumno`;

CREATE TABLE `materia_alumno` (
  `id_materia` int NOT NULL,
  `dni` varchar(60) NOT NULL,
  `aceptado` int DEFAULT NULL,
  PRIMARY KEY(id_materia, dni),
  FOREIGN KEY(dni) REFERENCES usuario(dni),
  FOREIGN KEY(id_materia) REFERENCES materia(id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trabajo`;

CREATE TABLE `trabajo` (
  `id_trabajo` int NOT NULL AUTO_INCREMENT,
  `nombre_trabajo` varchar(80) NOT NULL,
  `descripcion_trabajo` varchar(250) DEFAULT NULL,
  `porcentaje_nota` double NOT NULL,
  `correccion_nota` double NOT NULL,
  `nota` float DEFAULT NULL,
  `id_materia` int NOT NULL,
  `fecha_ini` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  PRIMARY KEY(id_trabajo),
  FOREIGN KEY(id_materia) REFERENCES materia(id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `competencia`;

CREATE TABLE `competencia` (
  `id_competencia` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(80) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_materia` int DEFAULT NULL,
  PRIMARY KEY(id_competencia),
  FOREIGN KEY(id_materia) REFERENCES materia(id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `entrega`;

CREATE TABLE `entrega` (
  `id_entrega` int NOT NULL AUTO_INCREMENT,
  `fecha_entrega` DATE NOT NULL,
  `id_trabajo` int NOT NULL,
  `dni` varchar(60) NOT NULL,
  `datos` LONGBLOB,
  PRIMARY KEY(id_entrega),
  FOREIGN KEY(dni) REFERENCES usuario(dni),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `criterio`;

CREATE TABLE `criterio` (
  `id_criterio` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) NOT NULL,
  `id_trabajo` int NOT NULL,
  PRIMARY KEY(id_criterio),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `criterio_competencia`;

CREATE TABLE `criterio_competencia` (
  `id_criterio` int NOT NULL,
  `id_competencia` int NOT NULL,
  PRIMARY KEY(id_criterio, id_competencia),
  FOREIGN KEY(id_criterio) REFERENCES criterio(id_criterio),
  FOREIGN KEY(id_competencia) REFERENCES competencia(id_competencia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `correccion_criterio`;

CREATE TABLE `correccion_criterio` (
  `id_correccion_criterio` int NOT NULL AUTO_INCREMENT,
  `id_criterio` int NOT NULL,
  `id_trabajo` int NOT NULL,
  `id_entrega` int NOT NULL,
  `correccion_alumno` int DEFAULT NULL,
  `comentario_alumno` varchar(200) DEFAULT NULL,
  `correccion_docente` int DEFAULT NULL,
  `comentario_docente` varchar(200) DEFAULT NULL,
  `dni_alumno` varchar(60) DEFAULT NULL,
  `dni_profesor` varchar(60) DEFAULT NULL,
  `fecha_fin_correccion` DATE NOT NULL,
  PRIMARY KEY(id_correccion_criterio),
  FOREIGN KEY(id_criterio) REFERENCES criterio(id_criterio),
  FOREIGN KEY(id_entrega) REFERENCES entrega(id_entrega),
  FOREIGN KEY(dni_alumno) REFERENCES usuario(dni),
  FOREIGN KEY(dni_profesor) REFERENCES usuario(dni),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `correccion_profesor`;

CREATE TABLE `correccion_profesor` (
  `id_correccion_profesor` int NOT NULL AUTO_INCREMENT,
  `id_criterio` int NOT NULL,
  `id_trabajo` int NOT NULL,
  `id_entrega` int NOT NULL,
  `correccion_docente` int DEFAULT NULL,
  `comentario_docente` varchar(200) DEFAULT NULL,
  `dni` varchar(60) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY(id_correccion_profesor),
  FOREIGN KEY(id_criterio) REFERENCES criterio(id_criterio),
  FOREIGN KEY(id_entrega) REFERENCES entrega(id_entrega),
  FOREIGN KEY(dni) REFERENCES usuario(dni),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `nota_trabajo`;

CREATE TABLE `nota_trabajo` (
  `id_trabajo` int NOT NULL,
  `id_entrega` int NOT NULL,
  `nota_trabajo` float DEFAULT NULL,
  `nota_correccion` float DEFAULT NULL,
  `dni` varchar(60) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY(id_trabajo, id_entrega),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo),
  FOREIGN KEY(id_entrega) REFERENCES entrega(id_entrega),
  FOREIGN KEY(dni) REFERENCES usuario(dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `nota_competencia`;

CREATE TABLE `nota_competencia` (
  `id_materia` int NOT NULL,
  `id_trabajo` int NOT NULL,
  `id_competencia` int NOT NULL,
  `nota_competencia` float DEFAULT NULL,
  `dni` varchar(60) DEFAULT NULL,
  `id_criterio` int NOT NULL,
  `visible` TINYINT(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY(id_materia, id_trabajo, id_competencia, dni, id_criterio),
  FOREIGN KEY(id_materia) REFERENCES materia(id_materia),
  FOREIGN KEY(id_trabajo) REFERENCES trabajo(id_trabajo),
  FOREIGN KEY(id_competencia) REFERENCES competencia(id_competencia),
  FOREIGN KEY(id_criterio) REFERENCES criterio(id_criterio),
  FOREIGN KEY(dni) REFERENCES usuario(dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `descripcion_rol`, `borrado_logico`) VALUES
(1, 'administrador', 'Rol de administrador que tiene acceso a todas las funcionalidades del sistema', 0),
(2, 'docente', 'Usuario que es un docente', 0),
(3, 'usuario', 'Usuario que es un alumno', 0);

/* pass = admin */
INSERT INTO `usuario` (`dni`, `nombre`, `apellidos_usuario`, `email`, `password`, `id_rol`, `direccion`, `telefono`, `fecha_nac`)
VALUES ('12345678Z', 'admin', 'admin admin', 'admin@admin.es', '21232f297a57a5a743894a0e4a801fc3', '1', 'admin', '666555444', '2013-04-09');
INSERT INTO `usuario` (`dni`, `nombre`, `apellidos_usuario`, `email`, `password`, `id_rol`, `direccion`, `telefono`, `fecha_nac`)
VALUES ('14488423X', 'profesor', 'profesor profesor', 'profesor@profesor.es', '21232f297a57a5a743894a0e4a801fc3', '2', 'profesor', '666555444', '2013-04-09');
INSERT INTO `usuario` (`dni`, `nombre`, `apellidos_usuario`, `email`, `password`, `id_rol`, `direccion`, `telefono`, `fecha_nac`)
VALUES ('22693548T', 'usuario', 'usuario usuario', 'usuario@usuario.es', '21232f297a57a5a743894a0e4a801fc3', '3', 'usuario', '666555444', '2013-04-09');

INSERT INTO `accion` (`id_accion`, `nombre_accion`, `descripcion_accion`) VALUES
(1, 'add', 'Insertar un elemento en base de datos'),
(2, 'delete', 'Borrado de un elemento en base de datos'),
(3, 'edit', 'Editar un elemento en base de datos'),
(4, 'search', 'Buscar un elemento en base de datos'),
(5, 'reactivate', 'Reactivar un elemento borrado de forma lógica'),
(6, 'searchBy', 'Ver toda la información para una tupla'),
(7, 'listar', 'Listado de las tuplas de una entidad'),
(8, 'getPasswordEmail', 'Recuperar contrasena'),
(9, 'editPass', 'Editar contrasena'),
(10, 'finalDelete', 'Eliminar permanentemente.'),
(11, 'assignTeacher', 'Asignar un profesor a la materia.'),
(12, 'assignCompetence', 'Asignar una competencia a la materia/trabajo.'),
(13, 'assignRandom', 'Asignar correcciones automáticamente.'),
(14, 'editTeacher', 'Realizar la corrección de una corrección de alumno por el profesor.'),
(15, 'showCorrection', 'Mostrar correcciones docentes a alumnos.'),
(16, 'makeVisible', 'Mostrar notas de competencias a alumnos.');

INSERT INTO `funcionalidad` (`id_funcionalidad`, `nombre_funcionalidad`, `descripcion_funcionalidad`) VALUES
(1, 'user', 'Gestión de usuarios'),
(2, 'logExcepcionAccion', 'Log de excepcion de acciones'),
(3, 'logExcepcionAtributo', 'Log de excepcion de atributo'),
(4, 'actionFunctionality', 'Gestión de acciones-funcionalidades'),
(5, 'auth', 'Autorizacion'),
(6, 'roleActionFunctionality', 'Gestión de rol-acción-funcionalidad'),
(7, 'subject', 'Gestión de materias'),
(8, 'subjectAssignment', 'Gestión de materia_solicitud'),
(9, 'subjectStudent', 'Gestión de materia_alumno'),
(10, 'academicCourse', 'Gestión de curso académico'),
(11, 'competence', 'Gestión de competencias'),
(12, 'project', 'Gestión de trabajos'),
(13, 'delivery', 'Gestión de entrega'),
(14, 'criteria', 'Gestión de criterios'),
(15, 'criteriaCompetence', 'Gestión de criterios_competencias'),
(16, 'correctionCriteria', 'Gestión de corrección_criterio'),
(17, 'correctionTeacher', 'Gestión de corrección_profesor'),
(18, 'gradeProject', 'Gestión de cálculo de notas de trabajos'),
(19, 'gradeCompetence', 'Gestión de cálculo de notas de competencias');

INSERT INTO `accion_funcionalidad` (`id_accion`, `id_funcionalidad`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 6),
(1, 7),
(1, 8),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 19),
(2, 1),
(2, 7),
(2, 8),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 19),
(3, 1),
(3, 7),
(3, 8),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(4, 1),
(4, 4),
(4, 6),
(4, 7),
(4, 8),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(5, 1),
(6, 1),
(8, 5),
(9, 1),
(10, 1),
(11, 7),
(12, 11),
(13, 16),
(14, 16),
(15, 17),
(16, 19);

INSERT INTO `rol_accion_funcionalidad` (`id_rol`, `id_accion`, `id_funcionalidad`) VALUES
(1, 1, 1),
(1, 1, 4),
(1, 1, 6),
(1, 1, 7),
(1, 1, 10),
(1, 1, 11),
(1, 2, 1),
(1, 2, 7),
(1, 2, 10),
(1, 2, 11),
(1, 3, 1),
(1, 3, 7),
(1, 3, 10),
(1, 3, 11),
(1, 4, 1),
(1, 4, 10),
(1, 4, 4),
(1, 4, 6),
(1, 4, 7),
(1, 4, 8),
(1, 5, 5),
(1, 6, 1),
(1, 8, 5),
(1, 9, 1),
(1, 10, 1),
(1, 11, 7),
(1, 12, 11),
(2, 1, 7),
(2, 1, 8),
(2, 1, 11),
(2, 1, 12),
(2, 1, 14),
(2, 1, 15),
(2, 1, 16),
(2, 1, 19),
(2, 2, 7),
(2, 2, 8),
(2, 2, 11),
(2, 2, 12),
(2, 2, 14),
(2, 2, 15),
(2, 2, 16),
(2, 2, 19),
(2, 3, 1),
(2, 3, 8),
(2, 3, 9),
(2, 3, 11),
(2, 3, 12),
(2, 3, 14),
(2, 3, 16),
(2, 3, 17),
(2, 3, 18),
(2, 3, 19),
(2, 4, 1),
(2, 4, 7),
(2, 4, 8),
(2, 4, 9),
(2, 4, 10),
(2, 4, 11),
(2, 4, 12),
(2, 4, 13),
(2, 4, 14),
(2, 4, 15),
(2, 4, 16),
(2, 4, 17),
(2, 4, 18),
(2, 4, 19),
(2, 6, 1),
(2, 8, 5),
(2, 9, 1),
(2, 11, 7),
(2, 12, 11),
(2, 13, 16),
(2, 14, 16),
(2, 15, 17),
(2, 16, 19),
(3, 1, 8),
(3, 1, 9),
(3, 1, 13),
(3, 1, 16),
(3, 2, 8),
(3, 2, 9),
(3, 2, 13),
(3, 2, 16),
(3, 3, 1),
(3, 3, 13),
(3, 3, 16),
(3, 4, 1),
(3, 4, 7),
(3, 4, 8),
(3, 4, 9),
(3, 4, 10),
(3, 4, 11),
(3, 4, 12),
(3, 4, 13),
(3, 4, 14),
(3, 4, 16),
(3, 4, 17),
(3, 4, 18),
(3, 4, 19),
(3, 8, 5),
(3, 9, 1);

INSERT INTO `curso_academico` (`id_curso_academico`, `nombre_curso_academico`) VALUES
(1, '22/23');

INSERT INTO `materia` (`id_materia`, `nombre_materia`, `creditos`, `dni`, `id_curso_academico`) VALUES
(1, 'Matemáticas', '60', NULL, 1);