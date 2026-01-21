-- Tabla de configuración PURISKIRI
-- Ejecutar este script para crear la tabla de configuración

CREATE TABLE IF NOT EXISTS puriskiri_config (
    clave VARCHAR(50) PRIMARY KEY,
    valor TEXT NOT NULL,
    descripcion VARCHAR(255),
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar valor inicial para límite de archivo
INSERT INTO puriskiri_config (clave, valor, descripcion) VALUES
('limite_archivo_mb', '100', 'Tamaño máximo de archivo en MB')
ON DUPLICATE KEY UPDATE descripcion = VALUES(descripcion);
