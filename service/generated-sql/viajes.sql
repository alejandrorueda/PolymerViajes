
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario`
(
    `idusuario` VARCHAR(24) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(24) NOT NULL,
    `apellidos` VARCHAR(24) NOT NULL,
    `avatar` VARCHAR(24) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `idperfil` INTEGER NOT NULL,
    PRIMARY KEY (`idusuario`),
    INDEX `usuario_fi_1d93a0` (`idperfil`),
    CONSTRAINT `usuario_fk_1d93a0`
        FOREIGN KEY (`idperfil`)
        REFERENCES `perfil` (`idperfil`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- perfil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil`
(
    `idperfil` INTEGER NOT NULL AUTO_INCREMENT,
    `descripcion` VARCHAR(255),
    `tipo_favorito` INT,
    `gustos` INT,
    `nacimiento` DATE,
    `destinos` INT,
    PRIMARY KEY (`idperfil`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- invitacion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `invitacion`;

CREATE TABLE `invitacion`
(
    `idusuario` VARCHAR(24) NOT NULL,
    `codigo` VARCHAR(128) NOT NULL,
    `activo` TINYINT(1) NOT NULL,
    PRIMARY KEY (`idusuario`,`codigo`,`activo`),
    CONSTRAINT `invitacion_fk_04eafb`
        FOREIGN KEY (`idusuario`)
        REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_amigo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_amigo`;

CREATE TABLE `usuario_amigo`
(
    `idusuario` VARCHAR(24) NOT NULL,
    `idamigo` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`idusuario`,`idamigo`),
    INDEX `fi_go` (`idamigo`),
    CONSTRAINT `usuario`
        FOREIGN KEY (`idusuario`)
        REFERENCES `usuario` (`idusuario`),
    CONSTRAINT `amigo`
        FOREIGN KEY (`idamigo`)
        REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- grupo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo`
(
    `idgrupo` INTEGER NOT NULL AUTO_INCREMENT,
    `informacion` TEXT(255) NOT NULL,
    `nombre` VARCHAR(50) NOT NULL,
    `administrador` TINYINT(1),
    PRIMARY KEY (`idgrupo`,`nombre`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- miembros_grupo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `miembros_grupo`;

CREATE TABLE `miembros_grupo`
(
    `idgrupo` INTEGER NOT NULL,
    `idusuario` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`idgrupo`,`idusuario`),
    INDEX `miembros_grupo_fi_04eafb` (`idusuario`),
    CONSTRAINT `miembros_grupo_fk_4e8c68`
        FOREIGN KEY (`idgrupo`)
        REFERENCES `grupo` (`idgrupo`),
    CONSTRAINT `miembros_grupo_fk_04eafb`
        FOREIGN KEY (`idusuario`)
        REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- viaje
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `viaje`;

CREATE TABLE `viaje`
(
    `idviaje` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(50) NOT NULL,
    `informacion` TEXT NOT NULL,
    `transporte` TEXT NOT NULL,
    `hospedaje` TEXT NOT NULL,
    `destino` VARCHAR(100) NOT NULL,
    `fecha_inicio` DATE,
    `fecha_final` DATE,
    `precio` DOUBLE,
    `imagenes` TEXT,
    `etiquetas` TEXT,
    PRIMARY KEY (`idviaje`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- viaje_mensajes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `viaje_mensajes`;

CREATE TABLE `viaje_mensajes`
(
    `idviaje` INTEGER NOT NULL,
    `idmensaje` INTEGER NOT NULL,
    PRIMARY KEY (`idviaje`,`idmensaje`),
    INDEX `viaje_mensajes_fi_7ad48a` (`idmensaje`),
    CONSTRAINT `viaje_mensajes_fk_d705e9`
        FOREIGN KEY (`idviaje`)
        REFERENCES `viaje` (`idviaje`),
    CONSTRAINT `viaje_mensajes_fk_7ad48a`
        FOREIGN KEY (`idmensaje`)
        REFERENCES `mensaje` (`idmensaje`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- viaje_usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `viaje_usuario`;

CREATE TABLE `viaje_usuario`
(
    `idviaje` INTEGER NOT NULL,
    `idusuario` VARCHAR(24) NOT NULL,
    `administrador` TINYINT(24),
    PRIMARY KEY (`idviaje`,`idusuario`),
    INDEX `viaje_usuario_fi_04eafb` (`idusuario`),
    CONSTRAINT `viaje_usuario_fk_d705e9`
        FOREIGN KEY (`idviaje`)
        REFERENCES `viaje` (`idviaje`),
    CONSTRAINT `viaje_usuario_fk_04eafb`
        FOREIGN KEY (`idusuario`)
        REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- grupo_viaje
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `grupo_viaje`;

CREATE TABLE `grupo_viaje`
(
    `idgrupo` INTEGER NOT NULL,
    `idviaje` INTEGER NOT NULL,
    `favorito` TINYINT(1) NOT NULL,
    PRIMARY KEY (`idgrupo`,`idviaje`,`favorito`),
    INDEX `grupo_viaje_fi_d705e9` (`idviaje`),
    CONSTRAINT `grupo_viaje_fk_4e8c68`
        FOREIGN KEY (`idgrupo`)
        REFERENCES `grupo` (`idgrupo`),
    CONSTRAINT `grupo_viaje_fk_d705e9`
        FOREIGN KEY (`idviaje`)
        REFERENCES `viaje` (`idviaje`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mensaje
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mensaje`;

CREATE TABLE `mensaje`
(
    `idmensaje` INTEGER NOT NULL AUTO_INCREMENT,
    `descripcion` TEXT NOT NULL,
    `asunto` VARCHAR(255) NOT NULL,
    `idusuario` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`idmensaje`),
    INDEX `mensaje_fi_04eafb` (`idusuario`),
    CONSTRAINT `mensaje_fk_04eafb`
        FOREIGN KEY (`idusuario`)
        REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mensaje_respuesta
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mensaje_respuesta`;

CREATE TABLE `mensaje_respuesta`
(
    `idmensaje` INTEGER NOT NULL,
    `idrespuesta` INTEGER NOT NULL,
    PRIMARY KEY (`idmensaje`,`idrespuesta`),
    INDEX `fi_puesta` (`idrespuesta`),
    CONSTRAINT `padre`
        FOREIGN KEY (`idmensaje`)
        REFERENCES `mensaje` (`idmensaje`),
    CONSTRAINT `respuesta`
        FOREIGN KEY (`idrespuesta`)
        REFERENCES `mensaje` (`idmensaje`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
