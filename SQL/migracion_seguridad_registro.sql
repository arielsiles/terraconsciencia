-- =====================================================
-- Migración: Seguridad en Registro de Usuarios
-- Terra ConsCiencia
-- Fecha: 2026-02-01
-- =====================================================

-- Ejecutar estos comandos en phpMyAdmin o cliente MySQL

-- 1. Agregar columnas nuevas a la tabla usuarios
ALTER TABLE usuarios ADD COLUMN activo TINYINT(1) DEFAULT 1;
ALTER TABLE usuarios ADD COLUMN token_confirmacion VARCHAR(64) NULL;
ALTER TABLE usuarios ADD COLUMN token_expira DATETIME NULL;
ALTER TABLE usuarios ADD COLUMN institucion VARCHAR(255) NULL;

-- 2. Los usuarios existentes quedan con activo=1 (por el DEFAULT)
--    Esto es intencional para no afectar cuentas existentes

-- 3. Cambiar el DEFAULT a 0 para futuros registros
ALTER TABLE usuarios ALTER COLUMN activo SET DEFAULT 0;

-- =====================================================
-- NOTA: Ejecutar manualmente en phpMyAdmin
-- =====================================================
