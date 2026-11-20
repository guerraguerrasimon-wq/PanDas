```sql
-- =============================================================================
-- PANIA - DATABASE SCHEMA
-- Descripción: Estructura general de la base de datos
-- Motor: MySQL 8.0+
-- =============================================================================

CREATE DATABASE IF NOT EXISTS pania_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE pania_db;

-- =============================================================================
-- 1. USUARIOS Y SEGURIDAD
-- =============================================================================

CREATE TABLE roles (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre      VARCHAR(50) NOT NULL,
  descripcion VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_roles_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE permisos (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  codigo      VARCHAR(60) NOT NULL,
  modulo      VARCHAR(40) NOT NULL,
  descripcion VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_permisos_codigo (codigo)
) ENGINE=InnoDB;

CREATE TABLE rol_permisos (
  rol_id     INT UNSIGNED NOT NULL,
  permiso_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (rol_id, permiso_id),
  CONSTRAINT fk_rp_rol
    FOREIGN KEY (rol_id) REFERENCES roles (id) ON DELETE CASCADE,
  CONSTRAINT fk_rp_permiso
    FOREIGN KEY (permiso_id) REFERENCES permisos (id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE usuarios (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre_usuario VARCHAR(50) NOT NULL,
  nombres        VARCHAR(80) NOT NULL,
  apellidos      VARCHAR(80) NOT NULL,
  correo         VARCHAR(120) NULL,
  password_hash  VARCHAR(255) NOT NULL,
  rol_id         INT UNSIGNED NOT NULL,
  activo         TINYINT(1) NOT NULL DEFAULT 1,
  ultimo_acceso  DATETIME NULL,
  creado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_usuario (nombre_usuario),
  UNIQUE KEY uq_usuarios_correo (correo),
  CONSTRAINT fk_usuarios_rol
    FOREIGN KEY (rol_id) REFERENCES roles (id)
) ENGINE=InnoDB;

-- =============================================================================
-- 2. CATÁLOGOS BASE
-- =============================================================================

CREATE TABLE unidades_medida (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre      VARCHAR(40) NOT NULL,
  abreviatura VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_unidad_nombre (nombre),
  UNIQUE KEY uq_unidad_abrev (abreviatura)
) ENGINE=InnoDB;

CREATE TABLE categorias (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre      VARCHAR(80) NOT NULL,
  descripcion VARCHAR(255) NULL,
  activo      TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categorias_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE proveedores (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre    VARCHAR(120) NOT NULL,
  nit       VARCHAR(30) NULL,
  contacto  VARCHAR(100) NULL,
  telefono  VARCHAR(30) NULL,
  correo    VARCHAR(120) NULL,
  direccion VARCHAR(200) NULL,
  activo    TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_proveedores_nombre (nombre),
  UNIQUE KEY uq_proveedores_nit (nit)
) ENGINE=InnoDB;

CREATE TABLE medios_pago (
  id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_medios_pago_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE cajas (
  id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(60) NOT NULL,
  activa TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_cajas_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE motivos_desperdicio (
  id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_motivos_nombre (nombre)
) ENGINE=InnoDB;

-- =============================================================================
-- 3. PRODUCTOS Y MATERIAS PRIMAS
-- =============================================================================

CREATE TABLE productos (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre         VARCHAR(120) NOT NULL,
  descripcion    VARCHAR(255) NULL,
  codigo_barras  VARCHAR(50) NULL,
  categoria_id   INT UNSIGNED NOT NULL,
  origen         ENUM('ELABORADO','REVENTA') NOT NULL DEFAULT 'ELABORADO',
  proveedor_id   INT UNSIGNED NULL,
  unidad_id      INT UNSIGNED NOT NULL,
  precio_venta   DECIMAL(12,2) NOT NULL,
  stock_actual   DECIMAL(14,3) NOT NULL DEFAULT 0,
  stock_minimo   DECIMAL(14,3) NOT NULL DEFAULT 0,
  disponible     TINYINT(1) NOT NULL DEFAULT 1,
  activo         TINYINT(1) NOT NULL DEFAULT 1,
  creado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_productos_nombre (nombre),
  UNIQUE KEY uq_productos_barras (codigo_barras),
  KEY idx_productos_categoria (categoria_id),
  CONSTRAINT fk_productos_categoria
    FOREIGN KEY (categoria_id) REFERENCES categorias (id),
  CONSTRAINT fk_productos_proveedor
    FOREIGN KEY (proveedor_id) REFERENCES proveedores (id),
  CONSTRAINT fk_productos_unidad
    FOREIGN KEY (unidad_id) REFERENCES unidades_medida (id),
  CONSTRAINT chk_productos_precio CHECK (precio_venta >= 0),
  CONSTRAINT chk_productos_stock CHECK (stock_actual >= 0),
  CONSTRAINT chk_productos_minimo CHECK (stock_minimo >= 0)
) ENGINE=InnoDB;

CREATE TABLE materias_primas (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre         VARCHAR(120) NOT NULL,
  descripcion    VARCHAR(255) NULL,
  unidad_id      INT UNSIGNED NOT NULL,
  stock_actual   DECIMAL(14,3) NOT NULL DEFAULT 0,
  stock_minimo   DECIMAL(14,3) NOT NULL DEFAULT 0,
  perecedero     TINYINT(1) NOT NULL DEFAULT 0,
  activo         TINYINT(1) NOT NULL DEFAULT 1,
  creado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_mp_nombre (nombre),
  CONSTRAINT fk_mp_unidad
    FOREIGN KEY (unidad_id) REFERENCES unidades_medida (id),
  CONSTRAINT chk_mp_stock CHECK (stock_actual >= 0),
  CONSTRAINT chk_mp_minimo CHECK (stock_minimo >= 0)
) ENGINE=InnoDB;

-- =============================================================================
-- 4. COMPRAS Y RECEPCIÓN
-- =============================================================================

CREATE TABLE compras (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  proveedor_id     INT UNSIGNED NOT NULL,
  fecha_compra     DATE NOT NULL,
  numero_documento VARCHAR(50) NULL,
  total            DECIMAL(14,2) NOT NULL DEFAULT 0,
  estado           ENUM('REGISTRADA','RECIBIDA_PARCIAL','RECIBIDA','ANULADA') NOT NULL DEFAULT 'REGISTRADA',
  usuario_id       INT UNSIGNED NOT NULL,
  observaciones    VARCHAR(255) NULL,
  creado_en        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_compras_doc (proveedor_id, numero_documento),
  KEY idx_compras_fecha (fecha_compra),
  CONSTRAINT fk_compras_proveedor
    FOREIGN KEY (proveedor_id) REFERENCES proveedores (id),
  CONSTRAINT fk_compras_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT chk_compras_total CHECK (total >= 0)
) ENGINE=InnoDB;

CREATE TABLE detalle_compras (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  compra_id        INT UNSIGNED NOT NULL,
  materia_prima_id INT UNSIGNED NULL,
  producto_id      INT UNSIGNED NULL,
  cantidad         DECIMAL(14,3) NOT NULL,
  precio_unitario  DECIMAL(14,2) NOT NULL,
  subtotal         DECIMAL(16,2) GENERATED ALWAYS AS (ROUND(cantidad * precio_unitario, 2)) STORED,
  PRIMARY KEY (id),
  KEY idx_dc_compra (compra_id),
  KEY idx_dc_mp (materia_prima_id),
  KEY idx_dc_producto (producto_id),
  CONSTRAINT fk_dc_compra
    FOREIGN KEY (compra_id) REFERENCES compras (id) ON DELETE CASCADE,
  CONSTRAINT fk_dc_mp
    FOREIGN KEY (materia_prima_id) REFERENCES materias_primas (id),
  CONSTRAINT fk_dc_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT chk_dc_item CHECK (
    (materia_prima_id IS NOT NULL AND producto_id IS NULL)
    OR
    (materia_prima_id IS NULL AND producto_id IS NOT NULL)
  ),
  CONSTRAINT chk_dc_cant CHECK (cantidad > 0),
  CONSTRAINT chk_dc_precio CHECK (precio_unitario >= 0)
) ENGINE=InnoDB;

CREATE TABLE recepciones_compra (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  compra_id     INT UNSIGNED NOT NULL,
  fecha_hora    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id    INT UNSIGNED NOT NULL,
  observaciones VARCHAR(255) NULL,
  PRIMARY KEY (id),
  KEY idx_rc_compra (compra_id),
  CONSTRAINT fk_rc_compra
    FOREIGN KEY (compra_id) REFERENCES compras (id),
  CONSTRAINT fk_rc_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
) ENGINE=InnoDB;

CREATE TABLE detalle_recepcion (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  recepcion_id      INT UNSIGNED NOT NULL,
  detalle_compra_id INT UNSIGNED NOT NULL,
  cantidad_recibida DECIMAL(14,3) NOT NULL,
  fecha_vencimiento DATE NULL,
  observaciones     VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_dr_recepcion_detalle (recepcion_id, detalle_compra_id),
  CONSTRAINT fk_dr_recepcion
    FOREIGN KEY (recepcion_id) REFERENCES recepciones_compra (id) ON DELETE CASCADE,
  CONSTRAINT fk_dr_detalle
    FOREIGN KEY (detalle_compra_id) REFERENCES detalle_compras (id),
  CONSTRAINT chk_dr_cant CHECK (cantidad_recibida >= 0)
) ENGINE=InnoDB;

-- =============================================================================
-- 5. RECETAS Y PRODUCCIÓN
-- =============================================================================

CREATE TABLE recetas (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  producto_id   INT UNSIGNED NOT NULL,
  rendimiento   DECIMAL(14,3) NOT NULL DEFAULT 1,
  instrucciones TEXT NULL,
  activa        TINYINT(1) NOT NULL DEFAULT 1,
  creado_en     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_recetas_producto (producto_id),
  CONSTRAINT fk_recetas_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT chk_recetas_rend CHECK (rendimiento > 0)
) ENGINE=InnoDB;

CREATE TABLE receta_ingredientes (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  receta_id        INT UNSIGNED NOT NULL,
  materia_prima_id INT UNSIGNED NOT NULL,
  cantidad         DECIMAL(14,3) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_ri_receta_mp (receta_id, materia_prima_id),
  CONSTRAINT fk_ri_receta
    FOREIGN KEY (receta_id) REFERENCES recetas (id) ON DELETE CASCADE,
  CONSTRAINT fk_ri_mp
    FOREIGN KEY (materia_prima_id) REFERENCES materias_primas (id),
  CONSTRAINT chk_ri_cant CHECK (cantidad > 0)
) ENGINE=InnoDB;

CREATE TABLE ordenes_produccion (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  codigo               VARCHAR(25) NOT NULL,
  producto_id          INT UNSIGNED NOT NULL,
  receta_id            INT UNSIGNED NOT NULL,
  cantidad_planificada DECIMAL(14,3) NOT NULL,
  fecha_programada     DATE NOT NULL,
  responsable_id       INT UNSIGNED NOT NULL,
  estado               ENUM('PLANIFICADA','EN_EJECUCION','EJECUTADA','CANCELADA') NOT NULL DEFAULT 'PLANIFICADA',
  inicio_ejecucion     DATETIME NULL,
  fin_ejecucion        DATETIME NULL,
  creado_por           INT UNSIGNED NOT NULL,
  observaciones        VARCHAR(255) NULL,
  creado_en            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_op_codigo (codigo),
  KEY idx_op_fecha (fecha_programada),
  CONSTRAINT fk_op_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_op_receta
    FOREIGN KEY (receta_id) REFERENCES recetas (id),
  CONSTRAINT fk_op_responsable
    FOREIGN KEY (responsable_id) REFERENCES usuarios (id),
  CONSTRAINT fk_op_creado_por
    FOREIGN KEY (creado_por) REFERENCES usuarios (id),
  CONSTRAINT chk_op_cant CHECK (cantidad_planificada > 0)
) ENGINE=InnoDB;

CREATE TABLE orden_produccion_insumos (
  id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
  orden_id           INT UNSIGNED NOT NULL,
  materia_prima_id   INT UNSIGNED NOT NULL,
  cantidad_requerida DECIMAL(14,3) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_opi_orden_mp (orden_id, materia_prima_id),
  CONSTRAINT fk_opi_orden
    FOREIGN KEY (orden_id) REFERENCES ordenes_produccion (id) ON DELETE CASCADE,
  CONSTRAINT fk_opi_mp
    FOREIGN KEY (materia_prima_id) REFERENCES materias_primas (id),
  CONSTRAINT chk_opi_cant CHECK (cantidad_requerida > 0)
) ENGINE=InnoDB;

CREATE TABLE lotes_produccion (
  id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
  codigo_lote        VARCHAR(30) NOT NULL,
  orden_id           INT UNSIGNED NOT NULL,
  producto_id        INT UNSIGNED NOT NULL,
  cantidad_elaborada DECIMAL(14,3) NOT NULL,
  fecha_fabricacion  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_vencimiento  DATE NULL,
  usuario_id         INT UNSIGNED NOT NULL,
  observaciones      VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_lotes_codigo (codigo_lote),
  KEY idx_lotes_orden (orden_id),
  CONSTRAINT fk_lotes_orden
    FOREIGN KEY (orden_id) REFERENCES ordenes_produccion (id),
  CONSTRAINT fk_lotes_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_lotes_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT chk_lotes_cant CHECK (cantidad_elaborada > 0)
) ENGINE=InnoDB;

-- =============================================================================
-- 6. CAJA
-- =============================================================================

CREATE TABLE sesiones_caja (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  caja_id              INT UNSIGNED NOT NULL,
  fecha_jornada        DATE NOT NULL,
  usuario_apertura_id  INT UNSIGNED NOT NULL,
  fecha_hora_apertura  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  valor_inicial        DECIMAL(14,2) NOT NULL,
  estado               ENUM('ABIERTA','CERRADA') NOT NULL DEFAULT 'ABIERTA',
  usuario_cierre_id    INT UNSIGNED NULL,
  fecha_hora_cierre    DATETIME NULL,
  ingresos_registrados DECIMAL(14,2) NULL,
  dinero_contado       DECIMAL(14,2) NULL,
  diferencia           DECIMAL(14,2) GENERATED ALWAYS AS (
    dinero_contado - (valor_inicial + ingresos_registrados)
  ) STORED,
  base_siguiente_dia   DECIMAL(14,2) NULL,
  observaciones        VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_sesion_caja_jornada (caja_id, fecha_jornada),
  CONSTRAINT fk_sc_caja
    FOREIGN KEY (caja_id) REFERENCES cajas (id),
  CONSTRAINT fk_sc_apertura
    FOREIGN KEY (usuario_apertura_id) REFERENCES usuarios (id),
  CONSTRAINT fk_sc_cierre
    FOREIGN KEY (usuario_cierre_id) REFERENCES usuarios (id),
  CONSTRAINT chk_sc_inicial CHECK (valor_inicial >= 0),
  CONSTRAINT chk_sc_contado CHECK (dinero_contado IS NULL OR dinero_contado >= 0),
  CONSTRAINT chk_sc_base CHECK (
    base_siguiente_dia IS NULL
    OR dinero_contado IS NULL
    OR base_siguiente_dia <= dinero_contado
  )
) ENGINE=InnoDB;

-- =============================================================================
-- 7. VENTAS
-- =============================================================================

CREATE TABLE ventas (
  id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  sesion_caja_id INT UNSIGNED NOT NULL,
  cajero_id      INT UNSIGNED NOT NULL,
  fecha_hora     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total          DECIMAL(14,2) NOT NULL DEFAULT 0,
  estado         ENUM('PENDIENTE','CONFIRMADA','ANULADA') NOT NULL DEFAULT 'PENDIENTE',
  observaciones  VARCHAR(255) NULL,
  PRIMARY KEY (id),
  KEY idx_ventas_fecha (fecha_hora),
  KEY idx_ventas_sesion (sesion_caja_id),
  CONSTRAINT fk_ventas_sesion
    FOREIGN KEY (sesion_caja_id) REFERENCES sesiones_caja (id),
  CONSTRAINT fk_ventas_cajero
    FOREIGN KEY (cajero_id) REFERENCES usuarios (id),
  CONSTRAINT chk_ventas_total CHECK (total >= 0)
) ENGINE=InnoDB;

CREATE TABLE detalle_ventas (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  venta_id        BIGINT UNSIGNED NOT NULL,
  producto_id     INT UNSIGNED NOT NULL,
  cantidad        DECIMAL(14,3) NOT NULL,
  precio_unitario DECIMAL(12,2) NOT NULL,
  subtotal        DECIMAL(16,2) GENERATED ALWAYS AS (
    ROUND(cantidad * precio_unitario, 2)
  ) STORED,
  PRIMARY KEY (id),
  KEY idx_dv_venta (venta_id),
  KEY idx_dv_producto (producto_id),
  CONSTRAINT fk_dv_venta
    FOREIGN KEY (venta_id) REFERENCES ventas (id) ON DELETE CASCADE,
  CONSTRAINT fk_dv_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT chk_dv_cant CHECK (cantidad > 0),
  CONSTRAINT chk_dv_precio CHECK (precio_unitario >= 0)
) ENGINE=InnoDB;

CREATE TABLE pagos_venta (
  id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  venta_id       BIGINT UNSIGNED NOT NULL,
  medio_pago_id  INT UNSIGNED NOT NULL,
  valor_recibido DECIMAL(14,2) NOT NULL,
  referencia     VARCHAR(60) NULL,
  PRIMARY KEY (id),
  KEY idx_pv_venta (venta_id),
  CONSTRAINT fk_pv_venta
    FOREIGN KEY (venta_id) REFERENCES ventas (id) ON DELETE CASCADE,
  CONSTRAINT fk_pv_medio
    FOREIGN KEY (medio_pago_id) REFERENCES medios_pago (id),
  CONSTRAINT chk_pv_valor CHECK (valor_recibido >= 0)
) ENGINE=InnoDB;

-- =============================================================================
-- 8. DESPERDICIOS
-- =============================================================================

CREATE TABLE desperdicios (
  id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
  materia_prima_id   INT UNSIGNED NULL,
  producto_id        INT UNSIGNED NULL,
  lote_produccion_id INT UNSIGNED NULL,
  cantidad           DECIMAL(14,3) NOT NULL,
  etapa              ENUM('PRODUCCION','COMERCIALIZACION','ALMACENAMIENTO') NOT NULL DEFAULT 'PRODUCCION',
  motivo_id          INT UNSIGNED NULL,
  descripcion_motivo VARCHAR(255) NULL,
  fecha_hora         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id         INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_desp_fecha (fecha_hora),
  CONSTRAINT fk_desp_mp
    FOREIGN KEY (materia_prima_id) REFERENCES materias_primas (id),
  CONSTRAINT fk_desp_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_desp_lote
    FOREIGN KEY (lote_produccion_id) REFERENCES lotes_produccion (id),
  CONSTRAINT fk_desp_motivo
    FOREIGN KEY (motivo_id) REFERENCES motivos_desperdicio (id),
  CONSTRAINT fk_desp_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT chk_desp_item CHECK (
    (materia_prima_id IS NOT NULL AND producto_id IS NULL)
    OR
    (materia_prima_id IS NULL AND producto_id IS NOT NULL)
  ),
  CONSTRAINT chk_desp_cant CHECK (cantidad > 0),
  CONSTRAINT chk_desp_motivo CHECK (
    motivo_id IS NOT NULL OR descripcion_motivo IS NOT NULL
  )
) ENGINE=InnoDB;

-- =============================================================================
-- 9. MOVIMIENTOS DE INVENTARIO
-- =============================================================================

CREATE TABLE movimientos_inventario (
  id                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  materia_prima_id     INT UNSIGNED NULL,
  producto_id          INT UNSIGNED NULL,
  tipo                 ENUM('ENTRADA','SALIDA') NOT NULL,
  motivo               ENUM('COMPRA','VENTA','CONSUMO_PRODUCCION','PRODUCCION','DESPERDICIO','AJUSTE','OTRO') NOT NULL,
  cantidad             DECIMAL(14,3) NOT NULL,
  fecha_hora           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_vencimiento    DATE NULL,
  usuario_id           INT UNSIGNED NOT NULL,
  observaciones        VARCHAR(255) NULL,
  detalle_recepcion_id INT UNSIGNED NULL,
  detalle_venta_id     BIGINT UNSIGNED NULL,
  orden_insumo_id      INT UNSIGNED NULL,
  lote_produccion_id   INT UNSIGNED NULL,
  desperdicio_id       INT UNSIGNED NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_mov_recepcion (detalle_recepcion_id),
  UNIQUE KEY uq_mov_venta (detalle_venta_id),
  UNIQUE KEY uq_mov_insumo (orden_insumo_id),
  UNIQUE KEY uq_mov_lote (lote_produccion_id),
  UNIQUE KEY uq_mov_desp (desperdicio_id),
  KEY idx_mov_mp (materia_prima_id, fecha_hora),
  KEY idx_mov_producto (producto_id, fecha_hora),
  KEY idx_mov_vencimiento (fecha_vencimiento),
  CONSTRAINT fk_mov_mp
    FOREIGN KEY (materia_prima_id) REFERENCES materias_primas (id),
  CONSTRAINT fk_mov_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_mov_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT fk_mov_recepcion
    FOREIGN KEY (detalle_recepcion_id) REFERENCES detalle_recepcion (id),
  CONSTRAINT fk_mov_venta
    FOREIGN KEY (detalle_venta_id) REFERENCES detalle_ventas (id),
  CONSTRAINT fk_mov_insumo
    FOREIGN KEY (orden_insumo_id) REFERENCES orden_produccion_insumos (id),
  CONSTRAINT fk_mov_lote
    FOREIGN KEY (lote_produccion_id) REFERENCES lotes_produccion (id),
  CONSTRAINT fk_mov_desp
    FOREIGN KEY (desperdicio_id) REFERENCES desperdicios (id),
  CONSTRAINT chk_mov_item CHECK (
    (materia_prima_id IS NOT NULL AND producto_id IS NULL)
    OR
    (materia_prima_id IS NULL AND producto_id IS NOT NULL)
  ),
  CONSTRAINT chk_mov_cant CHECK (cantidad > 0)
) ENGINE=InnoDB;

-- =============================================================================
-- 10. ANALÍTICA Y RECOMENDACIONES
-- =============================================================================

CREATE TABLE recomendaciones_produccion (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  producto_id          INT UNSIGNED NOT NULL,
  fecha_generacion     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  periodo_inicio       DATE NOT NULL,
  periodo_fin          DATE NOT NULL,
  ventas_periodo       DECIMAL(14,3) NOT NULL DEFAULT 0,
  promedio_diario      DECIMAL(14,3) NOT NULL DEFAULT 0,
  existencias_actuales DECIMAL(14,3) NOT NULL DEFAULT 0,
  cantidad_recomendada DECIMAL(14,3) NULL,
  datos_suficientes    TINYINT(1) NOT NULL DEFAULT 1,
  usuario_id           INT UNSIGNED NULL,
  observaciones        VARCHAR(255) NULL,
  PRIMARY KEY (id),
  KEY idx_rec_producto (producto_id, fecha_generacion),
  CONSTRAINT fk_rec_producto
    FOREIGN KEY (producto_id) REFERENCES productos (id),
  CONSTRAINT fk_rec_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
  CONSTRAINT chk_rec_periodo CHECK (periodo_fin >= periodo_inicio)
) ENGINE=InnoDB;

-- =============================================================================
-- 11. TRIGGERS DE INTEGRIDAD
-- =============================================================================

DELIMITER $$

-- Impide salidas que dejen existencias negativas.

CREATE TRIGGER trg_mov_inv_bi
BEFORE INSERT ON movimientos_inventario
FOR EACH ROW
BEGIN
  DECLARE v_stock DECIMAL(14,3);

  IF NEW.tipo = 'SALIDA' THEN

    IF NEW.materia_prima_id IS NOT NULL THEN
      SELECT stock_actual INTO v_stock
      FROM materias_primas
      WHERE id = NEW.materia_prima_id
      FOR UPDATE;
    ELSE
      SELECT stock_actual INTO v_stock
      FROM productos
      WHERE id = NEW.producto_id
      FOR UPDATE;
    END IF;

    IF v_stock IS NULL OR v_stock < NEW.cantidad THEN
      SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Existencias insuficientes para registrar la salida';
    END IF;

  END IF;
END$$

-- Mantiene stock_actual sincronizado con los movimientos.

CREATE TRIGGER trg_mov_inv_ai
AFTER INSERT ON movimientos_inventario
FOR EACH ROW
BEGIN
  DECLARE v_delta DECIMAL(14,3);

  SET v_delta = IF(NEW.tipo = 'ENTRADA', NEW.cantidad, -NEW.cantidad);

  IF NEW.materia_prima_id IS NOT NULL THEN
    UPDATE materias_primas
    SET stock_actual = stock_actual + v_delta
    WHERE id = NEW.materia_prima_id;
  ELSE
    UPDATE productos
    SET stock_actual = stock_actual + v_delta
    WHERE id = NEW.producto_id;
  END IF;
END$$

-- Los movimientos son inmutables.

CREATE TRIGGER trg_mov_inv_bu
BEFORE UPDATE ON movimientos_inventario
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45000'
  SET MESSAGE_TEXT = 'Los movimientos de inventario no se pueden modificar; registre un ajuste';
END$$

CREATE TRIGGER trg_mov_inv_bd
BEFORE DELETE ON movimientos_inventario
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45000'
  SET MESSAGE_TEXT = 'Los movimientos de inventario no se pueden eliminar; registre un ajuste';
END$$

-- Una caja cerrada no admite nuevas ventas.

CREATE TRIGGER trg_ventas_bi
BEFORE INSERT ON ventas
FOR EACH ROW
BEGIN
  DECLARE v_estado VARCHAR(10);

  SELECT estado INTO v_estado
  FROM sesiones_caja
  WHERE id = NEW.sesion_caja_id;

  IF v_estado IS NULL OR v_estado <> 'ABIERTA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'No se pueden registrar ventas: la caja no esta abierta';
  END IF;
END$$

DELIMITER ;

-- =============================================================================
-- 12. VISTAS
-- =============================================================================

-- Existencias generales.

CREATE VIEW vw_existencias AS
SELECT
  'MATERIA_PRIMA' AS tipo_item,
  mp.id AS item_id,
  mp.nombre,
  u.abreviatura AS unidad,
  mp.stock_actual,
  mp.stock_minimo,
  mp.activo
FROM materias_primas mp
JOIN unidades_medida u ON u.id = mp.unidad_id

UNION ALL

SELECT
  'PRODUCTO',
  p.id,
  p.nombre,
  u.abreviatura,
  p.stock_actual,
  p.stock_minimo,
  p.activo
FROM productos p
JOIN unidades_medida u ON u.id = p.unidad_id;

-- Alertas de stock mínimo.

CREATE VIEW vw_alertas_stock AS
SELECT
  tipo_item,
  item_id,
  nombre,
  unidad,
  stock_actual,
  stock_minimo,
  (stock_minimo - stock_actual) AS faltante
FROM vw_existencias
WHERE activo = 1
  AND stock_minimo > 0
  AND stock_actual <= stock_minimo;

-- Vencimientos.

CREATE VIEW vw_vencimientos AS
SELECT
  m.id AS movimiento_id,
  IF(m.materia_prima_id IS NOT NULL, 'MATERIA_PRIMA', 'PRODUCTO') AS tipo_item,
  COALESCE(m.materia_prima_id, m.producto_id) AS item_id,
  COALESCE(mp.nombre, p.nombre) AS nombre,
  l.codigo_lote,
  m.cantidad AS cantidad_ingresada,
  COALESCE(m.fecha_vencimiento, l.fecha_vencimiento) AS fecha_vencimiento,
  DATEDIFF(
    COALESCE(m.fecha_vencimiento, l.fecha_vencimiento),
    CURDATE()
  ) AS dias_restantes,
  CASE
    WHEN COALESCE(m.fecha_vencimiento, l.fecha_vencimiento) < CURDATE()
      THEN 'VENCIDO'
    WHEN COALESCE(m.fecha_vencimiento, l.fecha_vencimiento) <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)
      THEN 'PROXIMO_A_VENCER'
    ELSE 'VIGENTE'
  END AS estado
FROM movimientos_inventario m
LEFT JOIN materias_primas mp ON mp.id = m.materia_prima_id
LEFT JOIN productos p ON p.id = m.producto_id
LEFT JOIN lotes_produccion l ON l.id = m.lote_produccion_id
WHERE m.tipo = 'ENTRADA'
  AND COALESCE(m.fecha_vencimiento, l.fecha_vencimiento) IS NOT NULL;

-- Diferencias entre compras y recepciones.

CREATE VIEW vw_diferencias_compra AS
SELECT
  dc.compra_id,
  dc.id AS detalle_compra_id,
  COALESCE(mp.nombre, p.nombre) AS item,
  dc.cantidad AS cantidad_comprada,
  COALESCE(SUM(dr.cantidad_recibida), 0) AS cantidad_recibida,
  dc.cantidad - COALESCE(SUM(dr.cantidad_recibida), 0) AS diferencia
FROM detalle_compras dc
LEFT JOIN materias_primas mp ON mp.id = dc.materia_prima_id
LEFT JOIN productos p ON p.id = dc.producto_id
LEFT JOIN detalle_recepcion dr ON dr.detalle_compra_id = dc.id
GROUP BY dc.compra_id, dc.id, mp.nombre, p.nombre, dc.cantidad;

-- Costos de adquisición por materia prima.

CREATE VIEW vw_costo_materia_prima AS
SELECT
  mp.id AS materia_prima_id,
  mp.nombre,
  u.abreviatura AS unidad,
  SUM(x.cantidad * x.precio_unitario) / NULLIF(SUM(x.cantidad), 0) AS costo_promedio_ponderado,
  MIN(x.precio_unitario) AS costo_minimo,
  MAX(x.precio_unitario) AS costo_maximo,
  (
    SELECT dc2.precio_unitario
    FROM detalle_compras dc2
    JOIN compras c2 ON c2.id = dc2.compra_id
    WHERE dc2.materia_prima_id = mp.id
      AND c2.estado <> 'ANULADA'
    ORDER BY c2.fecha_compra DESC, dc2.id DESC
    LIMIT 1
  ) AS ultimo_costo
FROM materias_primas mp
JOIN unidades_medida u ON u.id = mp.unidad_id
LEFT JOIN (
  SELECT
    dc.materia_prima_id,
    dc.cantidad,
    dc.precio_unitario
  FROM detalle_compras dc
  JOIN compras c ON c.id = dc.compra_id
  WHERE c.estado <> 'ANULADA'
    AND dc.materia_prima_id IS NOT NULL
) x ON x.materia_prima_id = mp.id
GROUP BY mp.id, mp.nombre, u.abreviatura;

-- Costo estimado de ingredientes por producto.

CREATE VIEW vw_costo_producto AS
SELECT
  p.id AS producto_id,
  p.nombre AS producto,
  r.id AS receta_id,
  r.rendimiento,
  SUM(ri.cantidad * c.costo_promedio_ponderado) AS costo_estimado_receta,
  SUM(ri.cantidad * c.costo_promedio_ponderado) / r.rendimiento AS costo_estimado_unitario,
  SUM(c.costo_promedio_ponderado IS NULL) AS ingredientes_sin_costo,
  (SUM(c.costo_promedio_ponderado IS NULL) = 0) AS costo_completo
FROM recetas r
JOIN productos p ON p.id = r.producto_id
JOIN receta_ingredientes ri ON ri.receta_id = r.id
JOIN vw_costo_materia_prima c ON c.materia_prima_id = ri.materia_prima_id
GROUP BY p.id, p.nombre, r.id, r.rendimiento;

-- Ventas confirmadas por día y producto.

CREATE VIEW vw_ventas_diarias_producto AS
SELECT
  DATE(v.fecha_hora) AS fecha,
  p.id AS producto_id,
  p.nombre AS producto,
  c.nombre AS categoria,
  SUM(dv.cantidad) AS unidades_vendidas,
  SUM(dv.subtotal) AS valor_vendido
FROM ventas v
JOIN detalle_ventas dv ON dv.venta_id = v.id
JOIN productos p ON p.id = dv.producto_id
JOIN categorias c ON c.id = p.categoria_id
WHERE v.estado = 'CONFIRMADA'
GROUP BY DATE(v.fecha_hora), p.id, p.nombre, c.nombre;

-- Ingresos por medio de pago.

CREATE VIEW vw_ventas_por_medio_pago AS
SELECT
  DATE(v.fecha_hora) AS fecha,
  mp.nombre AS medio_pago,
  COUNT(DISTINCT v.id) AS num_ventas,
  SUM(pv.valor_recibido) AS valor_recibido
FROM ventas v
JOIN pagos_venta pv ON pv.venta_id = v.id
JOIN medios_pago mp ON mp.id = pv.medio_pago_id
WHERE v.estado = 'CONFIRMADA'
GROUP BY DATE(v.fecha_hora), mp.nombre;

-- Historial de caja.

CREATE VIEW vw_historial_caja AS
SELECT
  s.id AS sesion_id,
  c.nombre AS caja,
  s.fecha_jornada,
  CONCAT(ua.nombres, ' ', ua.apellidos) AS abierta_por,
  s.fecha_hora_apertura,
  s.valor_inicial,
  CONCAT(uc.nombres, ' ', uc.apellidos) AS cerrada_por,
  s.fecha_hora_cierre,
  s.ingresos_registrados,
  s.dinero_contado,
  s.diferencia,
  s.base_siguiente_dia,
  s.estado
FROM sesiones_caja s
JOIN cajas c ON c.id = s.caja_id
JOIN usuarios ua ON ua.id = s.usuario_apertura_id
LEFT JOIN usuarios uc ON uc.id = s.usuario_cierre_id;

-- Detalle de desperdicios.

CREATE VIEW vw_desperdicios_detalle AS
SELECT
  d.id,
  d.fecha_hora,
  d.etapa,
  IF(d.materia_prima_id IS NOT NULL, 'MATERIA_PRIMA', 'PRODUCTO') AS tipo_item,
  COALESCE(mp.nombre, p.nombre) AS item,
  d.cantidad,
  COALESCE(m.nombre, d.descripcion_motivo) AS motivo,
  CONCAT(u.nombres, ' ', u.apellidos) AS registrado_por
FROM desperdicios d
LEFT JOIN materias_primas mp ON mp.id = d.materia_prima_id
LEFT JOIN productos p ON p.id = d.producto_id
LEFT JOIN motivos_desperdicio m ON m.id = d.motivo_id
JOIN usuarios u ON u.id = d.usuario_id;

-- =============================================================================
-- FIN DEL SCHEMA DE PANIA
-- =============================================================================