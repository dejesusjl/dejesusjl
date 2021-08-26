CREATE TABLE `balance_gastos_auxiliares` (
	`idbalance_gastos_auxiliares` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` longtext,
	`idauxiliar_principales` varchar(450) DEFAULT NULL,
	`idlogistica` varchar(950) DEFAULT NULL,
	`fecha_movimiento` date DEFAULT NULL,
	`nomenclatura` longtext,
	`direccion` varchar(450) DEFAULT NULL,
	`idfoliogo` varchar(450) DEFAULT NULL,
	`visible` varchar(450) DEFAULT 'SI',
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`col1` int(11) DEFAULT NULL,
	`col2` varchar(450) DEFAULT NULL,
	`col3` varchar(450) DEFAULT NULL,
	PRIMARY KEY (`idbalance_gastos_auxiliares`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.balance_gastos_auxiliares;
INSERT INTO panamotors_des.balance_gastos_auxiliares
SELECT * FROM sistema_ccp_productivo.balance_gastos_auxiliares ;
/* --------------------------------------------------------------- */

CREATE TABLE `balance_gastos_operacion` (
	`idbalance_gastos_operacion` int(11) NOT NULL AUTO_INCREMENT,
	`concepto` varchar(950) DEFAULT NULL,
	`idcatalogo_provedores` varchar(950) DEFAULT NULL,
	`responsable` varchar(950) DEFAULT NULL,
	`idcatalogo_departamento` varchar(950) DEFAULT NULL,
	`estatus` varchar(950) DEFAULT NULL,
	`idfoliogo` varchar(450) DEFAULT NULL,
	`apartado_usado` varchar(450) DEFAULT NULL,
	`tipo_movimiento` varchar(450) DEFAULT NULL,
	`efecto_movimiento` varchar(450) DEFAULT NULL,
	`fecha_movimiento` date DEFAULT NULL,
	`metodo_pago` varchar(450) DEFAULT NULL,
	`saldo_anterior` mediumtext,
	`saldo` mediumtext,
	`monto_precio` varchar(950) DEFAULT NULL,
	`serie_monto` varchar(950) DEFAULT NULL,
	`monto_total` varchar(950) DEFAULT NULL,
	`tipo_moneda` varchar(950) DEFAULT NULL
	,	`tipo_cambio` varchar(950) DEFAULT NULL,
	`gran_total` varchar(950) DEFAULT NULL,
	`cargo` varchar(950) DEFAULT NULL,
	`abono` varchar(950) DEFAULT NULL,
	`emisora_institucion` varchar(950) DEFAULT NULL,
	`emisora_agente` varchar(950) DEFAULT NULL,
	`receptora_institucion` varchar(950) DEFAULT NULL,
	`receptora_agente` varchar(950) DEFAULT NULL,
	`tipo_comprobante` varchar(450) DEFAULT NULL,
	`referencia` varchar(450) DEFAULT NULL,
	`datos_vin` varchar(950) DEFAULT NULL,
	`archivo` mediumtext,
	`comentarios` mediumtext,
	`idauxiliar_principales` varchar(1100) DEFAULT NULL,
	`comision` varchar(450) DEFAULT NULL,
	`columna1` varchar(950) DEFAULT NULL,
	`columna2` varchar(1100) DEFAULT NULL,
	`columna3` varchar(450) DEFAULT NULL,
	`columna5` varchar(950) DEFAULT NULL,
	`columna6` varchar(950) DEFAULT NULL,
	`columna7` varchar(450) DEFAULT NULL,
	`columna8` varchar(1100) DEFAULT NULL,
	`columna9` varchar(1100) DEFAULT NULL,
	`columna10` varchar(1100) DEFAULT NULL,
	`factura` varchar(1100) DEFAULT NULL,
	`datos_estatus` varchar(1100) DEFAULT NULL,
	`usuario` varchar(450) DEFAULT NULL,
	`fecha` datetime DEFAULT NULL,
	`visible` varchar(450) DEFAULT NULL,
	`comentarios_eliminacion` varchar(1500) DEFAULT NULL,
	`usuario_elimino` varchar(450) DEFAULT NULL,
	`fecha_eliminacion` datetime DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idbalance_gastos_operacion`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE  panamotors_des.balance_gastos_operacion;
INSERT INTO panamotors_des.balance_gastos_operacion
SELECT * FROM sistema_ccp_productivo.balance_gastos_operacion ;
/* --------------------------------------------------------------- */

CREATE TABLE `balance_gastos_operacion_bitacora` (
	`idbalance_gastos_operacion_bitacora` int(11) NOT NULL AUTO_INCREMENT,
	`descripcion` varchar(950) DEFAULT NULL,
	`tipo` varchar(455) DEFAULT NULL,
	`idorden_logistica` varchar(950) DEFAULT NULL,
	`comentarios` mediumtext,
	`coordenadas` varchar(455) DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`valor` varchar(45) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`visible` varchar(455) DEFAULT 'SI',
	PRIMARY KEY (`idbalance_gastos_operacion_bitacora`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.balance_gastos_operacion_bitacora;
INSERT INTO panamotors_des.balance_gastos_operacion_bitacora
SELECT * FROM sistema_ccp_productivo.balance_gastos_operacion_bitacora ;
/* --------------------------------------------------------------- */

CREATE TABLE `balance_gastos_recibos` (
	`idbalance_gastos_recibos` int(11) NOT NULL AUTO_INCREMENT,
	`fecha` date DEFAULT NULL,
	`monto` varchar(950) DEFAULT NULL,
	`emisora_institucion` varchar(450) DEFAULT NULL,
	`emisora_agente` varchar(450) DEFAULT NULL,
	`receptora_institucion` varchar(450) DEFAULT NULL,
	`receptora_agente` varchar(450) DEFAULT NULL,
	`concepto` varchar(950) DEFAULT NULL,
	`metodo_pago` varchar(450) DEFAULT NULL,
	`referencia` varchar(450) DEFAULT NULL,
	`comentarios` mediumtext,
	`idbalance_gastos_operacion` varchar(950) DEFAULT NULL,
	`id_tesoreria` varchar(950) DEFAULT NULL,
	`idauxiliar_principales` varchar(1100) DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`departamento` varchar(950) DEFAULT NULL,
	`fecha_guardado` datetime NOT NULL,
	`tipo_moneda` varchar(950) NOT NULL,
	`tipo_cambio` varchar(950) NOT NULL,
	`gran_total` varchar(950) NOT NULL,
	PRIMARY KEY (`idbalance_gastos_recibos`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.balance_gastos_recibos;
INSERT INTO panamotors_des.balance_gastos_recibos
SELECT * FROM sistema_ccp_productivo.balance_gastos_recibos ;
/* --------------------------------------------------------------- */

CREATE TABLE `balance_gastos_reembolso` (
	`idbalance_gastos_reembolso` int(11) NOT NULL AUTO_INCREMENT,
	`responsable` varchar(45) DEFAULT NULL,
	`monto` varchar(45) DEFAULT NULL,
	`comentarios` mediumtext,
	`estatus` varchar(45) DEFAULT NULL,
	`evidencia` mediumtext,
	`idbalance_gastos` varchar(45) DEFAULT NULL,
	`id_logistica` varchar(45) DEFAULT NULL,
	`usuario_creador` varchar(45) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` varchar(955) DEFAULT NULL,
	`fecha_evidencia` datetime DEFAULT NULL,
	`usuario_evidencia` varchar(955) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	PRIMARY KEY (`idbalance_gastos_reembolso`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.balance_gastos_reembolso;
INSERT INTO panamotors_des.balance_gastos_reembolso
SELECT * FROM sistema_ccp_productivo.balance_gastos_reembolso ;
/* --------------------------------------------------------------- */

CREATE TABLE `catalogo_monederos_electronicos` (
	`idcatalogo_monederos_electronicos` int(11) NOT NULL AUTO_INCREMENT,
	`nombre_tarjeta` varchar(455) NOT NULL,
	`tipo` varchar(950) NOT NULL,
	`no_tarjeta` varchar(950) DEFAULT NULL,
	`nip` varchar(950) DEFAULT NULL,
	`idempleados` varchar(450) NOT NULL,
	`columna_a` varchar(455) DEFAULT NULL,
	`columna_b` varchar(455) DEFAULT NULL,
	`columna_c` varchar(455) DEFAULT NULL,
	`visible` varchar(45) DEFAULT NULL,
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idcatalogo_monederos_electronicos`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_monederos_electronicos;
INSERT INTO panamotors_des.catalogo_monederos_electronicos
SELECT * FROM sistema_ccp_productivo.catalogo_monederos_electronicos ;
/* --------------------------------------------------------------- */

CREATE TABLE `catalogo_orden_logistica` (
	`idcatalogo_orden_logistica` int(11) NOT NULL AUTO_INCREMENT,
	`nombre_orden` varchar(955) NOT NULL,
	`departamento` varchar(455) DEFAULT NULL,
	`visible` varchar(45) NOT NULL DEFAULT 'SI',
	`columna_a` varchar(455) DEFAULT NULL,
	`columna_b` varchar(455) DEFAULT NULL,
	`columna_c` varchar(455) DEFAULT NULL,
	PRIMARY KEY (`idcatalogo_orden_logistica`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_orden_logistica;
INSERT INTO panamotors_des.catalogo_orden_logistica
SELECT * FROM sistema_ccp_productivo.catalogo_orden_logistica ;
/* --------------------------------------------------------------- */

CREATE TABLE `catalogo_unidades_utilitarios` (
	`idcatalogo_unidades_utilitarios` int(11) NOT NULL AUTO_INCREMENT,
	`marca` varchar(955) DEFAULT NULL,
	`version` varchar(955) DEFAULT NULL,
	`color` varchar(955) DEFAULT NULL,
	`modelo` varchar(955) DEFAULT NULL,
	`km` int(11) DEFAULT NULL,
	`transmicion` varchar(955) DEFAULT NULL,
	`vin` varchar(955) DEFAULT NULL,
	`matricula` varchar(955) DEFAULT NULL,
	`entidad` varchar(955) DEFAULT NULL,
	`pelicula_antiasalto` varchar(955) DEFAULT NULL,
	`fecha_instalacion` date DEFAULT NULL,
	`tipo_uso` varchar(955) DEFAULT NULL,
	`fecha_contratacion_seguro` date DEFAULT NULL,
	`vigencia` date DEFAULT NULL,
	`tenencias` varchar(955) DEFAULT NULL,
	`tarjeta_circulacion` varchar(955) DEFAULT NULL,
	`fecha_apertura` date DEFAULT NULL,
	`fecha_ingreso` date DEFAULT NULL,
	`fecha_ingreso_taller` date DEFAULT NULL,
	`fecha_salida_piso` date DEFAULT NULL,
	`dias_inventario` int(11) DEFAULT NULL,
	`indice_impuestos` mediumtext,
	`tipo_compra` varchar(955) DEFAULT NULL,
	`precio_compra` double DEFAULT NULL,
	`costo_total` double DEFAULT NULL,
	`tipo_venta` varchar(955) DEFAULT NULL,
	`estatus_unidad` varchar(955) DEFAULT NULL,
	`ubicacion` varchar(955) DEFAULT NULL,
	`comentario` mediumtext,
	`rendimiento_combustible` varchar(45) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	PRIMARY KEY (`idcatalogo_unidades_utilitarios`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_unidades_utilitarios;
INSERT INTO panamotors_des.catalogo_unidades_utilitarios
SELECT * FROM sistema_ccp_productivo.catalogo_unidades_utilitarios ;
/* --------------------------------------------------------------- */

CREATE TABLE `catalogo_unidades_utilitarios_bitacora` (
	`idcatalogo_unidades_utilitarios_bitacora` int(11) NOT NULL AUTO_INCREMENT,
	`descripcion` varchar(950) DEFAULT NULL,
	`tipo` varchar(455) DEFAULT NULL,
	`vin` varchar(950) DEFAULT NULL,
	`comentarios` mediumtext,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`valor` varchar(45) DEFAULT NULL,
	`columna_a` varchar(455) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`visible` varchar(455) DEFAULT 'SI',
	PRIMARY KEY (`idcatalogo_unidades_utilitarios_bitacora`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_unidades_utilitarios_bitacora;
INSERT INTO panamotors_des.catalogo_unidades_utilitarios_bitacora
SELECT * FROM sistema_ccp_productivo.catalogo_unidades_utilitarios_bitacora ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica` (
	`idorden_logistica` int(11) NOT NULL AUTO_INCREMENT,
	`fecha_solicitud` datetime DEFAULT NULL,
	`fecha_programada` datetime DEFAULT NULL,
	`fecha_estimada_solucion` datetime DEFAULT NULL,
	`fecha_salida` datetime DEFAULT NULL,
	`fecha_llega_destino` datetime DEFAULT NULL,
	`fecha_retorno` datetime DEFAULT NULL,
	`hora_real_solucion` datetime DEFAULT NULL,
	`tiempo_estimado` varchar(955) DEFAULT NULL,
	`estado_origen` varchar(955) DEFAULT NULL,
	`municipio_origen` varchar(955) DEFAULT NULL,
	`colonia_origen` varchar(955) DEFAULT NULL,
	`calle_origen` varchar(955) DEFAULT NULL,
	`coordenadas_origen` varchar(950) DEFAULT NULL,
	`cp_origen` varchar(45) DEFAULT NULL,
	`estado_destino` varchar(955) DEFAULT NULL,
	`municipio_destino` varchar(955) DEFAULT NULL,
	`colonia_destino` varchar(955) DEFAULT NULL,
	`calle_destino` varchar(955) DEFAULT NULL,
	`cp_destino` varchar(45) DEFAULT NULL,
	`ubicacion_destino` varchar(950) DEFAULT NULL,
	`idcontacto` varchar(950) DEFAULT NULL,
	`tipo_contacto` varchar(45) DEFAULT NULL,
	`kilometros` varchar(455) DEFAULT NULL,
	`rendimiento` varchar(450) DEFAULT NULL,
	`idsolicitante` varchar(950) DEFAULT NULL,
	`tipo_solicitante` varchar(955) DEFAULT NULL,
	`idfuente_inf` varchar(950) DEFAULT NULL,
	`tipo_fuente_inf` varchar(955) DEFAULT NULL,
	`idasigna` varchar(950) DEFAULT NULL,
	`tipo_asignante` varchar(955) DEFAULT NULL,
	`presupuesto` varchar(950) DEFAULT NULL,
	`cantidad_presupuesto` varchar(950) DEFAULT NULL,
	`reembolso` varchar(950) DEFAULT NULL,
	`cantidad_reembolso` varchar(950) DEFAULT NULL,
	`estatus` varchar(955) DEFAULT NULL,
	`comentario_general` mediumtext,
	`iddepartamento` varchar(45) DEFAULT NULL,
	`idcatalogo_orden_logistica` varchar(950) DEFAULT NULL,
	`columna_a` varchar(950) DEFAULT NULL,
	`columna_b` varchar(950) DEFAULT NULL,
	`columna_c` varchar(450) DEFAULT NULL,
	`columna_d` varchar(450) DEFAULT NULL,
	`columna_e` varchar(950) DEFAULT NULL,
	`columna_f` varchar(955) DEFAULT NULL,
	`columna_g` varchar(955) DEFAULT NULL,
	`coluna_h` varchar(955) DEFAULT NULL,
	`coluna_i` varchar(950) DEFAULT NULL,
	`visible` varchar(45) DEFAULT NULL,
	`usuario_creador` varchar(955) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica;
INSERT INTO panamotors_des.orden_logistica
SELECT * FROM sistema_ccp_productivo.orden_logistica ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_ayudante` (
	`idorden_logistica_ayudante` int(11) NOT NULL AUTO_INCREMENT,
	`id_colaborador_proveedor` int(11) NOT NULL,
	`tipo` varchar(455) DEFAULT NULL,
	`idorden_logistica` int(11) NOT NULL,
	`comentarios` mediumtext NOT NULL,
	`col_a` varchar(455) DEFAULT NULL,
	`col_b` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT NULL,
	`usuario_creador` varchar(955) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_ayudante`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_ayudante;
INSERT INTO panamotors_des.orden_logistica_ayudante
SELECT * FROM sistema_ccp_productivo.orden_logistica_ayudante ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_bitacora` (
	`idorden_logistica_bitacora` int(11) NOT NULL AUTO_INCREMENT,
	`descripcion` varchar(950) DEFAULT NULL,
	`tipo` varchar(455) DEFAULT NULL,
	`idorden_logistica` varchar(950) DEFAULT NULL,
	`comentarios` mediumtext,
	`coordenadas` varchar(455) DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`valor` varchar(45) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`visible` varchar(455) DEFAULT 'SI',
	PRIMARY KEY (`idorden_logistica_bitacora`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_bitacora;
INSERT INTO panamotors_des.orden_logistica_bitacora
SELECT * FROM sistema_ccp_productivo.orden_logistica_bitacora ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_documentacion` (
	`idorden_logistica_documentacion` int(11) NOT NULL AUTO_INCREMENT,
	`tipo` varchar(45) NOT NULL,
	`documento` varchar(45) NOT NULL,
	`valor` mediumtext NOT NULL,
	`idorden_logistica` int(11) NOT NULL,
	`evidencia` mediumtext,
	`vin` varchar(45) DEFAULT NULL,
	`id_responsable` varchar(45) DEFAULT NULL,
	`tipo_responsable` varchar(955) DEFAULT NULL,
	`monto_rembolso` varchar(955) DEFAULT NULL,
	`columna_a` varchar(955) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`columna_e` varchar(955) DEFAULT NULL,
	`visible` varchar(45) NOT NULL DEFAULT 'SI',
	`usuario_creador` varchar(455) NOT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_documentacion`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_documentacion;
INSERT INTO panamotors_des.orden_logistica_documentacion
SELECT * FROM sistema_ccp_productivo.orden_logistica_documentacion ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_inventario` (
	`idorden_logistica_inventario` int(11) NOT NULL AUTO_INCREMENT,
	`tipo_unidad_inventario` varchar(955) DEFAULT 'Unidad',
	`vin` varchar(955) DEFAULT NULL,
	`marca` varchar(955) DEFAULT NULL,
	`version` varchar(955) DEFAULT NULL,
	`color` varchar(955) DEFAULT NULL,
	`modelo` varchar(955) DEFAULT NULL,
	`idorden_logistia` varchar(45) DEFAULT NULL,
	`estatus_unidad` varchar(955) DEFAULT 'NO',
	`tipo` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` varchar(455) DEFAULT NULL,
	`columna_b` varchar(455) DEFAULT NULL,
	`columna_c` varchar(455) DEFAULT NULL,
	`columna_d` varchar(455) DEFAULT NULL,
	`columna_e` varchar(455) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_inventario`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_inventario;
INSERT INTO panamotors_des.orden_logistica_inventario
SELECT * FROM sistema_ccp_productivo.orden_logistica_inventario ;
/* --------------------------------------------------------------- */


CREATE TABLE `orden_logistica_proveedores` (
	`idorden_logistica_proveedores` int(100) NOT NULL AUTO_INCREMENT,
	`idprovedores_compuesto` varchar(950) NOT NULL,
	`nomeclatura` mediumtext,
	`nombre` varchar(1200) DEFAULT NULL,
	`apellidos` varchar(1200) DEFAULT NULL,
	`sexo` varchar(450) DEFAULT NULL,
	`rfc` varchar(450) DEFAULT NULL,
	`alias` varchar(750) DEFAULT NULL,
	`trato` varchar(450) DEFAULT NULL,
	`telefono_otro` varchar(100) DEFAULT NULL,
	`telefono_celular` varchar(100) DEFAULT NULL,
	`email` varchar(1200) DEFAULT NULL,
	`referencia_nombre` varchar(950) DEFAULT NULL,
	`referencia_celular` varchar(450) DEFAULT NULL,
	`referencia_fijo` varchar(450) DEFAULT NULL,
	`referencia_nombre2` varchar(950) DEFAULT NULL,
	`referencia_celular2` varchar(450) DEFAULT NULL,
	`referencia_fijo2` varchar(450) DEFAULT NULL,
	`referencia_nombre3` varchar(950) DEFAULT NULL,
	`referencia_celular3` varchar(450) DEFAULT NULL,
	`referencia_fijo3` varchar(450) DEFAULT NULL,
	`tipo_registro` varchar(600) DEFAULT NULL,
	`recomendado` varchar(900) DEFAULT NULL,
	`entrada` varchar(750) DEFAULT NULL,
	`asesor` varchar(900) DEFAULT NULL,
	`tipo_cliente` varchar(600) DEFAULT NULL,
	`tipo_credito` varchar(450) DEFAULT NULL,
	`linea_credito` varchar(1100) DEFAULT NULL,
	`codigo_postal` varchar(1200) DEFAULT NULL,
	`estado` varchar(1200) DEFAULT NULL,
	`delmuni` varchar(1200) DEFAULT NULL,
	`colonia` varchar(1200) DEFAULT NULL,
	`calle` varchar(1200) DEFAULT NULL,
	`foto_perfil` varchar(950) DEFAULT NULL,
	`visible` varchar(950) DEFAULT NULL,
	`usuario_creador` varchar(450) NOT NULL,
	`fecha_creacion` datetime NOT NULL,
	`fecha_guardado` datetime NOT NULL,
	`metodo_pago` varchar(950) DEFAULT NULL,
	`col1` varchar(950) DEFAULT NULL,
	`col2` varchar(950) DEFAULT NULL,
	`col3` varchar(950) DEFAULT NULL,
	`col4` varchar(950) DEFAULT NULL,
	`col5` varchar(950) DEFAULT NULL,
	`col6` varchar(950) DEFAULT NULL,
	`col7` varchar(950) DEFAULT NULL,
	`col8` varchar(950) DEFAULT NULL,
	`col9` varchar(950) DEFAULT NULL,
	`col10` varchar(950) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_proveedores`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_proveedores;
INSERT INTO panamotors_des.orden_logistica_proveedores
SELECT * FROM sistema_ccp_productivo.orden_logistica_proveedores ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_recurso` (
	`idorden_logistica_recurso` int(11) NOT NULL AUTO_INCREMENT,
	`fecha` date DEFAULT NULL,
	`monto` varchar(950) DEFAULT NULL,
	`emisora_institucion` varchar(450) DEFAULT NULL,
	`emisora_agente` varchar(450) DEFAULT NULL,
	`receptora_institucion` varchar(450) DEFAULT NULL,
	`receptora_agente` varchar(450) DEFAULT NULL,
	`concepto` varchar(950) DEFAULT NULL,
	`metodo_pago` varchar(450) DEFAULT NULL,
	`referencia` varchar(450) DEFAULT NULL,
	`comentarios` mediumtext,
	`idorden_logistica_documentacion` varchar(950) DEFAULT NULL,
	`idorden_logistica` varchar(1100) DEFAULT NULL,
	`id_tesoreria` varchar(950) DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`departamento` varchar(950) DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`tipo_moneda` varchar(950) DEFAULT NULL,
	`tipo_cambio` varchar(950) DEFAULT NULL,
	`gran_total` varchar(950) DEFAULT NULL,
	`estatus` varchar(45) DEFAULT NULL,
	`comentarios_auditor` varchar(45) DEFAULT NULL,
	`fecha_auditada` datetime DEFAULT NULL,
	`usuario_auditor` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_recurso`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_recurso;
INSERT INTO panamotors_des.orden_logistica_recurso
SELECT * FROM sistema_ccp_productivo.orden_logistica_recurso ;
/* --------------------------------------------------------------- */


CREATE TABLE `orden_logistica_recurso_entrega` (
	`idorden_logistica_recurso_entrega` int(11) NOT NULL AUTO_INCREMENT,
	`fecha` date DEFAULT NULL,
	`monto` varchar(950) DEFAULT NULL,
	`emisora_institucion` varchar(450) DEFAULT NULL,
	`emisora_agente` varchar(450) DEFAULT NULL,
	`receptora_institucion` varchar(450) DEFAULT NULL,
	`receptora_agente` varchar(450) DEFAULT NULL,
	`concepto` varchar(950) DEFAULT NULL,
	`metodo_pago` varchar(450) DEFAULT NULL,
	`referencia` varchar(450) DEFAULT NULL,
	`comentarios` mediumtext,
	`idorden_logistica_documentacion` varchar(950) DEFAULT NULL,
	`idorden_logistica` varchar(1100) DEFAULT NULL,
	`id_tesoreria` varchar(950) DEFAULT NULL,
	`usuario_creador` varchar(450) DEFAULT NULL,
	`departamento` varchar(950) DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`tipo_moneda` varchar(950) DEFAULT NULL,
	`tipo_cambio` varchar(950) DEFAULT NULL,
	`gran_total` varchar(950) DEFAULT NULL,
	`estatus` varchar(45) DEFAULT NULL,
	`comentarios_auditor` varchar(45) DEFAULT NULL,
	`fecha_auditada` datetime DEFAULT NULL,
	`usuario_auditor` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_recurso_entrega`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_recurso_entrega;
INSERT INTO panamotors_des.orden_logistica_recurso_entrega
SELECT * FROM sistema_ccp_productivo.orden_logistica_recurso_entrega ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_unidades` (
	`idorden_logistica_unidades` int(11) NOT NULL AUTO_INCREMENT,
	`tipo_orden` varchar(955) NOT NULL,
	`vin` varchar(955) NOT NULL DEFAULT 'S/N VIN',
	`tipo_unidad` varchar(955) DEFAULT NULL,
	`idresponsable` varchar(955) DEFAULT NULL,
	`tipo_responsable` varchar(255) DEFAULT NULL,
	`idpersona_asignada` varchar(455) DEFAULT NULL,
	`tipopersona_asignada` varchar(255) DEFAULT NULL,
	`idorden_logistica` varchar(45) DEFAULT NULL,
	`columna_a` varchar(955) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(955) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_unidades`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_unidades;
INSERT INTO panamotors_des.orden_logistica_unidades
SELECT * FROM sistema_ccp_productivo.orden_logistica_unidades ;
/* --------------------------------------------------------------- */

CREATE TABLE `unidades_utilitarios_herramientas` (
	`idunidades_utilitarios_herramientas` int(11) NOT NULL AUTO_INCREMENT,
	`vin` varchar(45) DEFAULT NULL,
	`valor` mediumtext DEFAULT NULL,
	`tipo` varchar(455) DEFAULT NULL,
	`descripcion` mediumtext,
	`idorden` varchar(950) DEFAULT NULL,
	`tipo_orden` varchar(45) DEFAULT NULL,
	`estatus` varchar(45) DEFAULT NULL,
	`comentarios` mediumtext,
	`fecha_vencimiento` date DEFAULT NULL,
	`visible` varchar(455) DEFAULT 'SI',
	`usuario_creador` varchar(450) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` varchar(955) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`columna_e` varchar(955) DEFAULT NULL,
	`columna_f` varchar(955) DEFAULT NULL,
	`columna_g` varchar(955) DEFAULT NULL,
	`columna_h` varchar(955) DEFAULT NULL,
	`columna_i` varchar(955) DEFAULT NULL,
	`columna_j` varchar(955) DEFAULT NULL,
	`columna_k` mediumtext,
	`columna_l` mediumtext,
	`fecha_a` date DEFAULT NULL,
	`fecha_b` date DEFAULT NULL,
	PRIMARY KEY (`idunidades_utilitarios_herramientas`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.unidades_utilitarios_herramientas;
INSERT INTO panamotors_des.unidades_utilitarios_herramientas
SELECT * FROM sistema_ccp_productivo.unidades_utilitarios_herramientas ;
/* --------------------------------------------------------------- */


/*21-01-2021*/
CREATE TABLE `orden_logistica_tipo_orden` (
	`idorden_logistica_tipo_orden` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` mediumtext,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` mediumtext,
	`columna_b` mediumtext,
	`columna_c` mediumtext,
	`columnna_d` mediumtext,
	`columna_e` varchar(955) DEFAULT NULL,
	`columna_f` varchar(955) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_tipo_orden`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_tipo_orden;
INSERT INTO panamotors_des.orden_logistica_tipo_orden
SELECT * FROM sistema_ccp_productivo.orden_logistica_tipo_orden ;
/* --------------------------------------------------------------- */



CREATE TABLE `orden_logistica_tipo_orden_departamento` (
	`idorden_logistica_tipo_orden_departamento` int(11) NOT NULL AUTO_INCREMENT,
	`idtipo_orden` varchar(45) DEFAULT NULL,
	`iddepartamento` varchar(45) DEFAULT NULL,
	`personal_autorizado` mediumtext,
	`columna_a` mediumtext,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT NULL,
	`fecha_creacion` varchar(45) DEFAULT NULL,
	`fecha_guardado` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_tipo_orden_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_tipo_orden_departamento;
INSERT INTO panamotors_des.orden_logistica_tipo_orden_departamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_tipo_orden_departamento ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_departamento_id` (
	`idorden_logistica_departamento_id` int(11) NOT NULL AUTO_INCREMENT,
	`iddepeartamento` varchar(45) DEFAULT NULL,
	`nombre_tabla` varchar(45) DEFAULT NULL,
	`columna_a` varchar(45) DEFAULT NULL,
	`columna_b` varchar(45) DEFAULT NULL,
	`columna_c` varchar(45) DEFAULT NULL,
	`columna_d` varchar(45) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_departamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_departamento_id;
INSERT INTO panamotors_des.orden_logistica_departamento_id
SELECT * FROM sistema_ccp_productivo.orden_logistica_departamento_id ;
/* --------------------------------------------------------------- */


CREATE TABLE `orden_logistica_puntos` (
	`idorden_logistica_puntos` int(11) NOT NULL AUTO_INCREMENT,
	`nombre_punto` mediumtext,
	`ubicacion` mediumtext,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` mediumtext,
	`columna_b` mediumtext,
	`columna_c` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_puntos`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_puntos;
INSERT INTO panamotors_des.orden_logistica_puntos
SELECT * FROM sistema_ccp_productivo.orden_logistica_puntos ;
/* --------------------------------------------------------------- */

/*22-01-2021*/

CREATE TABLE `orden_logistica_rol_vin` (
	`idorden_logistica_rol_vin` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` mediumtext,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` mediumtext,
	`columna_b` mediumtext,
	`columna_c` mediumtext,
	`columnna_d` mediumtext,
	`columna_e` varchar(955) DEFAULT NULL,
	`columna_f` varchar(955) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_tipo_orden`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_rol_vin;
INSERT INTO panamotors_des.orden_logistica_rol_vin
SELECT * FROM sistema_ccp_productivo.orden_logistica_rol_vin ;
/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_idrol_iddepartamento` (
	`idorden_logistica_idrol_iddepartamento` int(11) NOT NULL AUTO_INCREMENT,
	`idtipo_orden` varchar(45) DEFAULT NULL,
	`iddepartamento` varchar(45) DEFAULT NULL,
	`personal_autorizado` mediumtext,
	`columna_a` mediumtext,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`fecha_creacion` varchar(45) DEFAULT NULL,
	`fecha_guardado` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_idrol_iddepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_idrol_iddepartamento;
INSERT INTO panamotors_des.orden_logistica_idrol_iddepartamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_idrol_iddepartamento ;
/* --------------------------------------------------------------- */

-- 26-02-2021

CREATE TABLE `orden_logistica_colaborador_departamento` (
	`idorden_logistica_colaborador_departamento` int(11) NOT NULL AUTO_INCREMENT,
	`idempleado` varchar(45) DEFAULT NULL,
	`iddepartamento` varchar(45) DEFAULT NULL,
	`columna_a` mediumtext,
	`columna_b` mediumtext,
	`columna_d` mediumtext,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_colaborador_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_colaborador_departamento;
INSERT INTO panamotors_des.orden_logistica_colaborador_departamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_colaborador_departamento ;
/* --------------------------------------------------------------- */

-- 09-03-2021

CREATE TABLE `orden_logistica_autorizaciones` (
	`idorden_logistica_autorizaciones` int(11) NOT NULL AUTO_INCREMENT,
	`idorden_logistica` varchar(45) DEFAULT NULL,
	`idcolaborador` varchar(45) DEFAULT NULL,
	`tipo_colaborador` varchar(45) DEFAULT NULL,
	`tipo` varchar(955) DEFAULT NULL,
	`evidencia` mediumtext,
	`comentarios` mediumtext,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` varchar(955) DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_autorizaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_autorizaciones;
INSERT INTO panamotors_des.orden_logistica_autorizaciones
SELECT * FROM sistema_ccp_productivo.orden_logistica_autorizaciones ;
/* --------------------------------------------------------------- */

CREATE TABLE `unidades_utilitarios_km` (
	`idunidades_utilitarios_km` int(11) NOT NULL AUTO_INCREMENT,
	`vin` varchar(45) DEFAULT NULL,
	`rol_km` varchar(45) DEFAULT NULL,
	`km_anterior` varchar(955) DEFAULT NULL,
	`kilometraje` varchar(955) DEFAULT NULL,
	`archivo` mediumtext,
	`idcolaborador` varchar(955) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_b` varchar(955) DEFAULT NULL,
	`columna_c` varchar(955) DEFAULT NULL,
	`columna_d` varchar(955) DEFAULT NULL,
	`columna_e` varchar(955) DEFAULT NULL,
	PRIMARY KEY (`idunidades_utilitarios_km`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.unidades_utilitarios_km;
INSERT INTO panamotors_des.unidades_utilitarios_km
SELECT * FROM sistema_ccp_productivo.unidades_utilitarios_km ;
/* --------------------------------------------------------------- */

CREATE TABLE `catalogo_monedero_electronico_bitacora` (
	`id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
	`id_monedero_electronico` int(11) NOT NULL,
	`contenido` longtext COLLATE latin1_bin,
	`movimiento` varchar(45) COLLATE latin1_bin DEFAULT NULL,
	`evidencia` varchar(90) COLLATE latin1_bin DEFAULT NULL,
	`comentarios` longtext COLLATE latin1_bin,
	`usuario_creador` varchar(30) COLLATE latin1_bin DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`visible` varchar(45) COLLATE latin1_bin DEFAULT NULL,
	`columna_a` longtext COLLATE latin1_bin,
	`columna_b` longtext COLLATE latin1_bin,
	`columna_c` longtext COLLATE latin1_bin,
	`columna_d` longtext COLLATE latin1_bin,
	`columna_e` longtext COLLATE latin1_bin,
	`columna_f` longtext COLLATE latin1_bin,
	PRIMARY KEY (`id_bitacora`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;
/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_monedero_electronico_bitacora;
INSERT INTO panamotors_des.catalogo_monedero_electronico_bitacora
SELECT * FROM sistema_ccp_productivo.catalogo_monedero_electronico_bitacora ;
/* --------------------------------------------------------------- */

--14-06-2021

CREATE TABLE `orden_logistica_buscar_ordenes_extras` (
	`idorden_logistica_buscar_ordenes_extras` int(11) NOT NULL AUTO_INCREMENT,
	`idorden_logistica_tipo_orden` varchar(45) DEFAULT NULL,
	`tipo_funcion_buscador` varchar(455) DEFAULT NULL,
	`visible` varchar(45) DEFAULT 'SI',
	`usuario_creador` varchar(45) DEFAULT NULL,
	`fecha_creacion` datetime DEFAULT NULL,
	`fecha_guardado` datetime DEFAULT NULL,
	`columna_a` varchar(45) DEFAULT NULL,
	`columna_b` varchar(45) DEFAULT NULL,
	`columna_c` varchar(45) DEFAULT NULL,
	`columna_d` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`idorden_logistica_buscar_ordenes_extras`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_buscar_ordenes_extras;
INSERT INTO panamotors_des.orden_logistica_buscar_ordenes_extras
SELECT * FROM sistema_ccp_productivo.orden_logistica_buscar_ordenes_extras ;
/* --------------------------------------------------------------- */

-- 21-07-2021

/* --------------------------------------------------------------- */
CREATE TABLE `orden_logistica_archivos_casetas_combustible` (
`idorden_logistica_archivos_casetas_combustible` int(11) NOT NULL AUTO_INCREMENT,
`concepto` varchar(45) DEFAULT NULL,
`tipo_archivo` varchar(45) DEFAULT NULL,
`ruta` mediumtext,
`fecha_inicio` date DEFAULT NULL,
`fecha_fin` date DEFAULT NULL,
`total_movimientos` varchar(45) DEFAULT NULL,
`movimientos_insertados` varchar(45) DEFAULT NULL,
`movimientos_duplicados` varchar(45) DEFAULT NULL,
`movimientos_actualizados` varchar(45) DEFAULT NULL,
`movimientos_restantes` varchar(45) DEFAULT NULL,
`comentarios` mediumtext,
`visible` varchar(45) DEFAULT NULL,
`usuario_creador` varchar(45) DEFAULT NULL,
`fecha_creacion` datetime DEFAULT NULL,
`fecha_guardado` datetime DEFAULT NULL,
`columna_a` varchar(1000) DEFAULT NULL,
`columna_b` varchar(1000) DEFAULT NULL,
`columna_c` varchar(1000) DEFAULT NULL,
PRIMARY KEY (`idorden_logistica_archivos_casetas_combustible`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_archivos_casetas_combustible;
INSERT INTO panamotors_des.orden_logistica_archivos_casetas_combustible
SELECT * FROM sistema_ccp_productivo.orden_logistica_archivos_casetas_combustible ;
/* --------------------------------------------------------------- */


/* --------------------------------------------------------------- */
CREATE TABLE `orden_logistica_combustible` (
`idorden_logistica_combustible` int(11) NOT NULL AUTO_INCREMENT,
`tipo` varchar(100) DEFAULT NULL,
`concepto` varchar(100) DEFAULT NULL,
`fecha_movimiento` datetime DEFAULT NULL,
`cuenta` varchar(45) DEFAULT NULL,
`titular` varchar(255) DEFAULT NULL,
`tarjeta` varchar(45) DEFAULT NULL,
`establecimiento` varchar(455) DEFAULT NULL,
`rfc` varchar(45) DEFAULT NULL,
`litros` varchar(45) DEFAULT NULL,
`gran_total` varchar(45) DEFAULT NULL,
`precio_unitario` varchar(45) DEFAULT NULL,
`idorden_logistica_archivos_casetas_combustible` varchar(45) DEFAULT NULL,
`idorden_logistica` varchar(45) DEFAULT NULL,
`estatus` varchar(1000) DEFAULT NULL,
`referencia` varchar(45) DEFAULT NULL,
`columna_b` varchar(100) DEFAULT NULL,
`columna_c` varchar(1000) DEFAULT NULL,
`usuario_creador` varchar(45) DEFAULT NULL,
`visible` varchar(45) DEFAULT NULL,
`fecha_creacion` datetime DEFAULT NULL,
`fecha_guardado` datetime DEFAULT NULL,
PRIMARY KEY (`idorden_logistica_combustible`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_combustible;
INSERT INTO panamotors_des.orden_logistica_combustible
SELECT * FROM sistema_ccp_productivo.orden_logistica_combustible ;
/* --------------------------------------------------------------- */

-- 29-07-2021

/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_casetas` (
`idorden_logistica_casetas` int(11) NOT NULL AUTO_INCREMENT,
`tipo` varchar(45) DEFAULT NULL,
`concepto` varchar(45) DEFAULT NULL,
`idorden_logistica_archivos_casetas_combustible` varchar(45) DEFAULT NULL,
`responsable` varchar(455) DEFAULT NULL,
`tag` varchar(45) DEFAULT NULL,
`fecha_movimiento` datetime DEFAULT NULL,
`caseta` varchar(1000) DEFAULT NULL,
`carril` varchar(1000) DEFAULT NULL,
`clase` varchar(45) DEFAULT NULL,
`gran_total` varchar(45) DEFAULT NULL,
`consecar` varchar(45) DEFAULT NULL,
`idorden_logistica` varchar(1000) DEFAULT NULL,
`estatus` varchar(1000) DEFAULT NULL,
`columna_c` varchar(1000) DEFAULT NULL,
`visible` varchar(45) DEFAULT NULL,
`usuario_creador` varchar(45) DEFAULT NULL,
`fecha_creacion` datetime DEFAULT NULL,
`fecha_guardado` datetime DEFAULT NULL,
PRIMARY KEY (`idorden_logistica_casetas`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_casetas;
INSERT INTO panamotors_des.orden_logistica_casetas
SELECT * FROM sistema_ccp_productivo.orden_logistica_casetas ;

/* --------------------------------------------------------------- */

-- 10-08-2021

CREATE TABLE `catalogo_entidates` (
`idcatalogo_entidates` int(11) NOT NULL AUTO_INCREMENT,
`nombre_entidad` varchar(45) DEFAULT NULL,
`visible` varchar(45) DEFAULT NULL,
`columna_a` varchar(45) DEFAULT NULL,
`columna_b` varchar(45) DEFAULT NULL,
`columna_c` varchar(45) DEFAULT NULL,
PRIMARY KEY (`idcatalogo_entidates`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.catalogo_entidates;
INSERT INTO panamotors_des.catalogo_entidates
SELECT * FROM sistema_ccp_productivo.catalogo_entidates ;

/* --------------------------------------------------------------- */

--18-08-2021

CREATE TABLE `orden_logistica_id_excepciones` (
`idorden_logistica_id_excepciones` int(11) NOT NULL AUTO_INCREMENT,
`id` varchar(45) DEFAULT NULL,
`id_tipo` varchar(45) DEFAULT NULL,
`parametros` varchar(45) DEFAULT NULL,
`tipo` varchar(45) DEFAULT NULL,
`columna_a` varchar(1000) DEFAULT NULL,
`columna_b` varchar(1000) DEFAULT NULL,
`columna_c` varchar(1000) DEFAULT NULL,
`visible` varchar(45) DEFAULT NULL,
`usuario_creador` varchar(45) DEFAULT NULL,
`fecha_creacion` datetime DEFAULT NULL,
`fecha_guardado` datetime DEFAULT NULL,
PRIMARY KEY (`idorden_logistica_id_excepciones`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */

TRUNCATE panamotors_des.orden_logistica_id_excepciones;
INSERT INTO panamotors_des.orden_logistica_id_excepciones
SELECT * FROM sistema_ccp_productivo.orden_logistica_id_excepciones ;

/* --------------------------------------------------------------- */

CREATE TABLE `orden_logistica_token` (
`idorden_logistica_token` int(11) NOT NULL AUTO_INCREMENT,
`token` varchar(45) DEFAULT NULL,
`tipo_token` varchar(45) DEFAULT NULL,
`idorden_logistica` varchar(45) DEFAULT NULL,
`idcolaborador` varchar(45) DEFAULT NULL,
`tipocolaborador` varchar(45) DEFAULT NULL,
`fecha_expiracion_token` datetime DEFAULT NULL,
`columna_a` varchar(1000) DEFAULT NULL,
`columna_b` varchar(1000) DEFAULT NULL,
`columna_c` varchar(1000) DEFAULT NULL,
`visible` varchar(45) DEFAULT 'SI',
`usuario_creador` varchar(45) DEFAULT NULL,
`fecha_creacion` datetime DEFAULT NULL,
`fecha_guardado` datetime DEFAULT NULL,
PRIMARY KEY (`idorden_logistica_token`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


/* --------------------------------------------------------------- */
TRUNCATE panamotors_des.orden_logistica_token;
INSERT INTO panamotors_des.orden_logistica_token
SELECT * FROM sistema_ccp_productivo.orden_logistica_token ;

/* --------------------------------------------------------------- */




/* ---------------------VACIAR TABLAS ------------------------------------------ */
TRUNCATE panamotors_des.balance_gastos_auxiliares;
TRUNCATE panamotors_des.balance_gastos_operacion;
TRUNCATE panamotors_des.balance_gastos_operacion_bitacora;
TRUNCATE panamotors_des.balance_gastos_recibos;
TRUNCATE panamotors_des.balance_gastos_reembolso;
TRUNCATE panamotors_des.catalogo_monederos_electronicos;
TRUNCATE panamotors_des.catalogo_orden_logistica;
TRUNCATE panamotors_des.catalogo_unidades_utilitarios;
TRUNCATE panamotors_des.catalogo_unidades_utilitarios_bitacora;
TRUNCATE panamotors_des.orden_logistica;
TRUNCATE panamotors_des.orden_logistica_ayudante;
TRUNCATE panamotors_des.orden_logistica_bitacora;
TRUNCATE panamotors_des.orden_logistica_documentacion;
TRUNCATE panamotors_des.orden_logistica_inventario;
TRUNCATE panamotors_des.orden_logistica_proveedores;
TRUNCATE panamotors_des.orden_logistica_recurso;
TRUNCATE panamotors_des.orden_logistica_recurso_entrega;
TRUNCATE panamotors_des.orden_logistica_unidades;
TRUNCATE panamotors_des.unidades_utilitarios_herramientas;
TRUNCATE panamotors_des.orden_logistica_tipo_orden;
TRUNCATE panamotors_des.orden_logistica_tipo_orden_departamento;
TRUNCATE panamotors_des.orden_logistica_departamento_id;
TRUNCATE panamotors_des.orden_logistica_puntos;
TRUNCATE panamotors_des.orden_logistica_rol_vin;
TRUNCATE panamotors_des.orden_logistica_idrol_iddepartamento;
TRUNCATE panamotors_des.orden_logistica_colaborador_departamento;
TRUNCATE panamotors_des.orden_logistica_autorizaciones;
TRUNCATE panamotors_des.unidades_utilitarios_km;
TRUNCATE panamotors_des.catalogo_monedero_electronico_bitacora;
TRUNCATE panamotors_des.orden_logistica_buscar_ordenes_extras;
TRUNCATE panamotors_des.orden_logistica_archivos_casetas_combustible;
TRUNCATE panamotors_des.orden_logistica_combustible;
TRUNCATE panamotors_des.orden_logistica_casetas;
TRUNCATE panamotors_des.catalogo_entidates;

/* ---------------------Traspaso de Archivos ------------------------------------------ */


INSERT INTO panamotors_des.balance_gastos_auxiliares
SELECT * FROM sistema_ccp_productivo.balance_gastos_auxiliares ;

INSERT INTO panamotors_des.balance_gastos_operacion
SELECT * FROM sistema_ccp_productivo.balance_gastos_operacion ;

INSERT INTO panamotors_des.balance_gastos_operacion_bitacora
SELECT * FROM sistema_ccp_productivo.balance_gastos_operacion_bitacora ;

INSERT INTO panamotors_des.balance_gastos_recibos
SELECT * FROM sistema_ccp_productivo.balance_gastos_recibos ;

INSERT INTO panamotors_des.balance_gastos_reembolso
SELECT * FROM sistema_ccp_productivo.balance_gastos_reembolso ;

INSERT INTO panamotors_des.catalogo_monederos_electronicos
SELECT * FROM sistema_ccp_productivo.catalogo_monederos_electronicos ;

INSERT INTO panamotors_des.catalogo_orden_logistica
SELECT * FROM sistema_ccp_productivo.catalogo_orden_logistica ;

INSERT INTO panamotors_des.catalogo_unidades_utilitarios
SELECT * FROM sistema_ccp_productivo.catalogo_unidades_utilitarios ;

INSERT INTO panamotors_des.catalogo_unidades_utilitarios_bitacora
SELECT * FROM sistema_ccp_productivo.catalogo_unidades_utilitarios_bitacora ;

INSERT INTO panamotors_des.orden_logistica
SELECT * FROM sistema_ccp_productivo.orden_logistica ;

INSERT INTO panamotors_des.orden_logistica_ayudante
SELECT * FROM sistema_ccp_productivo.orden_logistica_ayudante ;

INSERT INTO panamotors_des.orden_logistica_bitacora
SELECT * FROM sistema_ccp_productivo.orden_logistica_bitacora ;

INSERT INTO panamotors_des.orden_logistica_documentacion
SELECT * FROM sistema_ccp_productivo.orden_logistica_documentacion ;

INSERT INTO panamotors_des.orden_logistica_inventario
SELECT * FROM sistema_ccp_productivo.orden_logistica_inventario ;

INSERT INTO panamotors_des.orden_logistica_proveedores
SELECT * FROM sistema_ccp_productivo.orden_logistica_proveedores ;

INSERT INTO panamotors_des.orden_logistica_recurso
SELECT * FROM sistema_ccp_productivo.orden_logistica_recurso ;

INSERT INTO panamotors_des.orden_logistica_recurso_entrega
SELECT * FROM sistema_ccp_productivo.orden_logistica_recurso_entrega ;

INSERT INTO panamotors_des.orden_logistica_unidades
SELECT * FROM sistema_ccp_productivo.orden_logistica_unidades ;

INSERT INTO panamotors_des.unidades_utilitarios_herramientas
SELECT * FROM sistema_ccp_productivo.unidades_utilitarios_herramientas ;

INSERT INTO panamotors_des.orden_logistica_tipo_orden
SELECT * FROM sistema_ccp_productivo.orden_logistica_tipo_orden ;

INSERT INTO panamotors_des.orden_logistica_tipo_orden_departamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_tipo_orden_departamento ;

INSERT INTO panamotors_des.orden_logistica_departamento_id
SELECT * FROM sistema_ccp_productivo.orden_logistica_departamento_id ;

INSERT INTO panamotors_des.orden_logistica_puntos
SELECT * FROM sistema_ccp_productivo.orden_logistica_puntos ;

INSERT INTO panamotors_des.orden_logistica_rol_vin
SELECT * FROM sistema_ccp_productivo.orden_logistica_rol_vin ;

INSERT INTO panamotors_des.orden_logistica_idrol_iddepartamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_idrol_iddepartamento ;

INSERT INTO panamotors_des.orden_logistica_colaborador_departamento
SELECT * FROM sistema_ccp_productivo.orden_logistica_colaborador_departamento ;

INSERT INTO panamotors_des.orden_logistica_autorizaciones
SELECT * FROM sistema_ccp_productivo.orden_logistica_autorizaciones ;

INSERT INTO panamotors_des.unidades_utilitarios_km
SELECT * FROM sistema_ccp_productivo.unidades_utilitarios_km ;

INSERT INTO panamotors_des.catalogo_monedero_electronico_bitacora
SELECT * FROM sistema_ccp_productivo.catalogo_monedero_electronico_bitacora ;

INSERT INTO panamotors_des.orden_logistica_buscar_ordenes_extras
SELECT * FROM sistema_ccp_productivo.orden_logistica_buscar_ordenes_extras ;

INSERT INTO panamotors_des.orden_logistica_combustible
SELECT * FROM sistema_ccp_productivo.orden_logistica_combustible ;

INSERT INTO panamotors_des.orden_logistica_casetas
SELECT * FROM sistema_ccp_productivo.orden_logistica_casetas ;

INSERT INTO panamotors_des.catalogo_entidates
SELECT * FROM sistema_ccp_productivo.catalogo_entidates ;

INSERT INTO panamotors_des.orden_logistica_archivos_casetas_combustible
SELECT * FROM sistema_ccp_productivo.orden_logistica_archivos_casetas_combustible ;