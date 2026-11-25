```sql
-- =============================================================================
-- PANIA - DATABASE SEEDS
-- Descripción: Datos iniciales del sistema
-- Motor: MySQL
-- =============================================================================

USE pania_db;

-- =============================================================================
-- 1. ROLES
-- =============================================================================

INSERT INTO roles (nombre, descripcion) VALUES
('Administrador', 'Configuración y administración general, consulta de información y reportes'),
('Panadero', 'Consulta de recetas, gestión de producción y registros operativos autorizados'),
('Cajero', 'Registro de ventas y operaciones de caja autorizadas');

-- =============================================================================
-- 2. PERMISOS
-- =============================================================================

INSERT INTO permisos (codigo, modulo, descripcion) VALUES
('usuarios.gestionar', 'usuarios', 'Registrar, editar, activar/desactivar usuarios y asignar roles'),
('productos.gestionar', 'productos', 'Registrar y actualizar productos y categorías'),
('productos.consultar', 'productos', 'Consultar el catálogo de productos'),
('materias_primas.gestionar', 'inventario', 'Registrar y actualizar materias primas'),
('proveedores.gestionar', 'inventario', 'Registrar y actualizar proveedores'),
('inventario.consultar', 'inventario', 'Consultar existencias'),
('inventario.entradas', 'inventario', 'Registrar entradas de inventario'),
('inventario.salidas', 'inventario', 'Registrar salidas de inventario'),
('inventario.minimos', 'inventario', 'Configurar existencias mínimas'),
('recetas.consultar', 'produccion', 'Consultar recetas'),
('recetas.gestionar', 'produccion', 'Registrar y actualizar recetas'),
('produccion.gestionar', 'produccion', 'Crear órdenes de producción'),
('produccion.ejecutar', 'produccion', 'Ejecutar órdenes y registrar lotes'),
('ventas.registrar', 'ventas', 'Registrar ventas y medios de pago'),
('ventas.consultar', 'ventas', 'Consultar historial de ventas'),
('desperdicios.registrar', 'desperdicios', 'Registrar desperdicios'),
('vencimientos.consultar', 'desperdicios', 'Consultar vencimientos'),
('compras.gestionar', 'compras', 'Registrar compras y recepciones'),
('costos.consultar', 'compras', 'Consultar costos de materias primas y producción'),
('caja.operar', 'caja', 'Abrir y cerrar caja'),
('caja.historial', 'caja', 'Consultar historial de caja'),
('dashboard.ver', 'reportes', 'Ver el dashboard'),
('reportes.consultar', 'reportes', 'Consultar reportes por fechas'),
('reportes.exportar', 'reportes', 'Exportar reportes a PDF y Excel'),
('analitica.ver', 'analitica', 'Ver analítica de ventas y Power BI'),
('recomendaciones.ver', 'analitica', 'Ver recomendaciones de producción');

-- =============================================================================
-- 3. ASIGNACIÓN DE PERMISOS
-- =============================================================================

-- Administrador: todos los permisos

INSERT INTO rol_permisos (rol_id, permiso_id)
SELECT r.id, p.id
FROM roles r
CROSS JOIN permisos p
WHERE r.nombre = 'Administrador';

-- Panadero

INSERT INTO rol_permisos (rol_id, permiso_id)
SELECT r.id, p.id
FROM roles r
JOIN permisos p ON p.codigo IN (
'productos.consultar',
'inventario.consultar',
'inventario.salidas',
'recetas.consultar',
'recetas.gestionar',
'produccion.gestionar',
'produccion.ejecutar',
'desperdicios.registrar',
'vencimientos.consultar',
'recomendaciones.ver'
)
WHERE r.nombre = 'Panadero';

-- Cajero

INSERT INTO rol_permisos (rol_id, permiso_id)
SELECT r.id, p.id
FROM roles r
JOIN permisos p ON p.codigo IN (
'productos.consultar',
'ventas.registrar',
'ventas.consultar',
'caja.operar'
)
WHERE r.nombre = 'Cajero';

-- =============================================================================
-- 4. UNIDADES DE MEDIDA
-- =============================================================================

INSERT INTO unidades_medida (nombre, abreviatura) VALUES
('Unidad', 'und'),
('Kilogramo', 'kg'),
('Gramo', 'g'),
('Libra', 'lb'),
('Litro', 'l'),
('Mililitro', 'ml');

-- =============================================================================
-- 5. CATEGORÍAS
-- =============================================================================

INSERT INTO categorias (nombre, descripcion) VALUES
('Pan', 'Pan elaborado en la panadería'),
('Bebidas', 'Bebidas calientes y otras bebidas'),
('Productos de reventa', 'Productos adquiridos a terceros para su venta');

-- =============================================================================
-- 6. MEDIOS DE PAGO
-- =============================================================================

INSERT INTO medios_pago (nombre) VALUES
('Efectivo'),
('Tarjeta'),
('Transferencia');

-- =============================================================================
-- 7. CAJAS
-- =============================================================================

INSERT INTO cajas (nombre) VALUES
('Caja principal');

-- =============================================================================
-- 8. MOTIVOS DE DESPERDICIO
-- =============================================================================

INSERT INTO motivos_desperdicio (nombre) VALUES
('Demanda inferior a la esperada'),
('Producción superior a la necesaria'),
('Producto vencido'),
('Producto dañado'),
('Error en la producción'),
('Otro');

-- =============================================================================
-- 9. PRODUCTOS INICIALES
-- =============================================================================

INSERT INTO productos (
nombre,
categoria_id,
origen,
unidad_id,
precio_venta,
disponible
)
SELECT
n.nombre,
c.id,
'ELABORADO',
u.id,
0,
0
FROM (
SELECT 'Pan blandito' AS nombre, 'Pan' AS cat
UNION ALL SELECT 'Pan rollo', 'Pan'
UNION ALL SELECT 'Pan coco', 'Pan'
UNION ALL SELECT 'Pan de queso', 'Pan'
UNION ALL SELECT 'Pan coco miel', 'Pan'
UNION ALL SELECT 'Pan hawaiano', 'Pan'
UNION ALL SELECT 'Tinto', 'Bebidas'
UNION ALL SELECT 'Café con leche', 'Bebidas'
UNION ALL SELECT 'Aromática', 'Bebidas'
) n
JOIN categorias c ON c.nombre = n.cat
JOIN unidades_medida u ON u.abreviatura = 'und';

-- =============================================================================
-- 10. MATERIAS PRIMAS INICIALES
-- =============================================================================

INSERT INTO materias_primas (nombre, unidad_id)
SELECT
n.nombre,
u.id
FROM (
SELECT 'Harina de trigo' AS nombre
UNION ALL SELECT 'Azúcar'
) n
JOIN unidades_medida u ON u.abreviatura = 'kg';

-- =============================================================================
-- FIN DE LOS DATOS INICIALES
-- =============================================================================
```