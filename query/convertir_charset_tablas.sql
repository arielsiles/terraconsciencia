-- ============================================================================
-- Script SQL: Conversión de Charset de Tablas a UTF8MB4
-- ============================================================================
-- Propósito: Convertir todas las tablas de la base de datos terracons a
--            UTF8MB4 con collation utf8mb4_unicode_ci
--
-- IMPORTANTE:
-- 1. Ejecutar DESPUÉS de reparar los datos con reparar_charset.php
-- 2. Hacer backup de la base de datos ANTES de ejecutar
-- 3. Ejecutar este script en phpMyAdmin o línea de comandos MySQL
--
-- Uso en phpMyAdmin:
-- 1. Seleccionar la base de datos 'terracons'
-- 2. Click en pestaña 'SQL'
-- 3. Copiar y pegar este script completo
-- 4. Click en 'Continuar'
--
-- Uso en línea de comandos:
-- mysql -u terra -p terracons < convertir_charset_tablas.sql
-- ============================================================================

-- Configurar charset para esta sesión
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Convertir el charset de la base de datos
ALTER DATABASE terracons CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ============================================================================
-- TABLAS PRINCIPALES
-- ============================================================================

-- Tabla: noticias
ALTER TABLE noticias CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: publicacion
ALTER TABLE publicacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: seccionpb1
ALTER TABLE seccionpb1 CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: seccionpb2
ALTER TABLE seccionpb2 CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: seccionpb3
ALTER TABLE seccionpb3 CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================================
-- TABLAS DE USUARIOS Y PERFILES
-- ============================================================================

-- Tabla: usuarios
ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: perfil
ALTER TABLE perfil CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: cargo
ALTER TABLE cargo CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================================
-- TABLAS DE JUEGOS
-- ============================================================================

-- Tabla: test (Juego 2 - Cuestionario)
ALTER TABLE test CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: orden_cartas (Juego 1 - Memoria)
ALTER TABLE orden_cartas CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: avion (Juego 3 - Flappy Bird)
ALTER TABLE avion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: ahorcados (Juego 4 - Ahorcado)
ALTER TABLE ahorcados CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: fov (Juego 5 - Falso o Verdadero)
ALTER TABLE fov CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================================
-- VERIFICACIÓN
-- ============================================================================

-- Mostrar el charset y collation de todas las tablas
SELECT
    TABLE_NAME AS 'Tabla',
    TABLE_COLLATION AS 'Collation',
    CHARACTER_SET_NAME AS 'Charset'
FROM
    information_schema.TABLES
WHERE
    TABLE_SCHEMA = 'terracons'
ORDER BY
    TABLE_NAME;

-- ============================================================================
-- RESULTADO ESPERADO
-- ============================================================================
-- Todas las tablas deberían mostrar:
-- - Charset: utf8mb4
-- - Collation: utf8mb4_unicode_ci
--
-- Si alguna tabla muestra charset diferente (latin1, utf8), ejecutar:
-- ALTER TABLE nombre_tabla CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- ============================================================================
