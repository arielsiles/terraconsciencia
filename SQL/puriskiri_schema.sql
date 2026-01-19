-- =====================================================
-- PURISKIRI - Script de creación de base de datos
-- Centro de Recursos Educativos para Docentes
-- Terra ConsCiencia - 2025
-- =====================================================

-- 1. Nuevo rol "Docente" en la tabla cargo
INSERT INTO cargo (id, descripcion) VALUES (3, 'Docente')
ON DUPLICATE KEY UPDATE descripcion = 'Docente';

-- 2. Tabla de categorías temáticas
CREATE TABLE IF NOT EXISTS puriskiri_categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    imagen VARCHAR(255),
    activo TINYINT(1) DEFAULT 1,
    orden INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar categorías iniciales
INSERT INTO puriskiri_categorias (nombre, slug, descripcion, orden) VALUES
('Seguridad Hídrica', 'agua', 'Recursos sobre cuidado del agua y huella hídrica', 1),
('Medio Ambiente', 'ambiente', 'Materiales sobre ecología y conservación', 2),
('Agricultura Sostenible', 'agricultura', 'Guías sobre prácticas agrícolas sostenibles', 3),
('Seguridad Alimentaria', 'alimentacion', 'Materiales sobre nutrición y alimentación', 4),
('Cambio Climático', 'clima', 'Recursos sobre adaptación y mitigación', 5),
('Biodiversidad', 'biodiversidad', 'Guías sobre flora y fauna local', 6)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- 3. Tabla de niveles educativos
CREATE TABLE IF NOT EXISTS puriskiri_niveles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    slug VARCHAR(30) NOT NULL UNIQUE,
    orden INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar niveles educativos
INSERT INTO puriskiri_niveles (nombre, slug, orden) VALUES
('Primaria', 'primaria', 1),
('Secundaria', 'secundaria', 2),
('Universitario', 'universitario', 3),
('Todos los niveles', 'todos', 4)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- 4. Tabla principal de recursos educativos
CREATE TABLE IF NOT EXISTS puriskiri_recursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria_id INT NOT NULL,
    nivel_id INT NOT NULL,
    tipo_archivo ENUM('pdf','ppt','pptx','doc','docx','xlsx') NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    ruta_portada VARCHAR(255),
    autor VARCHAR(100),
    palabras_clave VARCHAR(255),
    usuario_id INT NOT NULL,
    descargas INT DEFAULT 0,
    destacado TINYINT(1) DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES puriskiri_categorias(id) ON DELETE RESTRICT,
    FOREIGN KEY (nivel_id) REFERENCES puriskiri_niveles(id) ON DELETE RESTRICT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FULLTEXT INDEX idx_busqueda (titulo, descripcion, palabras_clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Índices adicionales para mejorar el rendimiento
CREATE INDEX idx_categoria ON puriskiri_recursos(categoria_id);
CREATE INDEX idx_nivel ON puriskiri_recursos(nivel_id);
CREATE INDEX idx_usuario ON puriskiri_recursos(usuario_id);
CREATE INDEX idx_destacado ON puriskiri_recursos(destacado);
CREATE INDEX idx_activo ON puriskiri_recursos(activo);
CREATE INDEX idx_fecha ON puriskiri_recursos(fecha_creacion);
