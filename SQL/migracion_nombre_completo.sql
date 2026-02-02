-- Migración: Agregar campo nombre_completo a la tabla usuarios
-- Fecha: 2026-02-01
-- Descripción: Añade columna para almacenar el nombre completo del usuario
--              como parte de las mejoras UX en el formulario de registro

-- Agregar columna nombre_completo a la tabla usuarios
ALTER TABLE usuarios ADD COLUMN nombre_completo VARCHAR(255) NULL AFTER nombre_usuario;

-- Verificar que la columna fue creada correctamente
-- SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE
-- FROM INFORMATION_SCHEMA.COLUMNS
-- WHERE TABLE_SCHEMA = 'terracons' AND TABLE_NAME = 'usuarios' AND COLUMN_NAME = 'nombre_completo';
