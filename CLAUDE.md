# CLAUDE.md

Este archivo proporciona orientación a Claude Code (claude.ai/code) al trabajar con código en este repositorio.

## Descripción del Proyecto

Terra ConsCiencia es una plataforma web educativa enfocada en la conciencia ambiental y la conservación del agua. La aplicación está construida con PHP, MySQL, jQuery y Bootstrap, ejecutándose en un entorno de servidor XAMPP (Apache).

## Stack Tecnológico

- **Backend**: PHP 7+ con MySQLi
- **Base de datos**: MySQL (base de datos: `terracons`)
- **Frontend**: HTML5, CSS3, Bootstrap 5, jQuery
- **Servidor**: Apache (entorno XAMPP en Windows)
- **Plantilla**: TemplateMo 581 Kind Heart Charity (altamente personalizada)

## Conexión a la Base de Datos

La configuración de la base de datos está en `PHP/conexionBe.php`:
- Host: `localhost`
- Base de datos: `terracons`
- Usuario: `terra`
- Puerto: `3306`

**Importante**: `PHP/config.php` y `PHP/conexionBe.php` están en gitignore. Nunca hacer commit de credenciales de base de datos.

## Arquitectura de la Aplicación

### Gestión de Sesiones y Autenticación

La aplicación tiene tres niveles principales de acceso:
1. **Público (Sin Login)**: `SinLogin.php` - Acceso limitado a Calculadora y Noticias
2. **Usuarios Autenticados**: `ConLogin.php` - Acceso a todas las funcionalidades (Calculadora, Noticias, Publicaciones, Trivias/Juegos)
3. **Administradores**: `ConLoginAdm.php` - Panel de administración con gestión de contenido

Flujo de autenticación:
- Login: `PHP/loginUsuarioBe.php` (hash SHA-512 de contraseñas, vulnerable a inyección SQL)
- Registro: `PHP/registroUsuarioBe.php` (crea usuario + perfil con transacción)
- Verificación de sesión: Cada página protegida valida `$_SESSION['usuario']` y `$_SESSION['rol']`
- Logout: `PHP/cerrar_sesion.php`

El acceso basado en roles se aplica mediante:
```php
$roles_permitidos = ['Administrador','Usuario'];
if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
    header("Location: SinLogin.php");
    session_destroy();
    die();
}
```

### Módulos Principales de la Aplicación

1. **Calculadora Hídrica**
   - Formulario multipágina: `CalculadoraInicio.html` → `CalculadoraPag1.html` → `CalculadoraPag2.html` → `CalculadoraPag3.html` → `CalculadoraPag4.html` → `CalculadoraPagFinal.html`
   - Scripts: `JS/scriptCalPag1.js`, `JS/scriptCalPag2.js`, `JS/scriptCalPag3.js`, `JS/scriptCalPag4.js`, `JS/scriptCalPagFin.js`
   - Calcula la huella hídrica del usuario a través de un cuestionario guiado

2. **Noticias**
   - Vista de usuario: `Noticias.php` (autenticado), `NoticiasSl.php` (público)
   - Página de detalle: `DetalleNoticia.php?id={id_noticia}`
   - Administración: `NoticiasAdm.php`, `SubirNoticias.php`
   - Backend: `PHP/subir_noticias.php`
   - Tabla de base de datos: `noticias` (id_noticia, titulo_noticia, descripcion_noticia, imagen_noticia, creacion_noticia, noticia_destacada)

3. **Publicaciones**
   - Vista de usuario: `Publicaciones.php` (basado en carrusel, secciones cargadas vía `publicaciones_s1.php`, `publicaciones_s2.php`, `publicaciones_s3.php`)
   - Administración: `PublicacionesAdm.php`, `SubirPublicacion.php`
   - Backend: `PHP/crear_publicacion.php`
   - Tabla de base de datos: `publicacion` (id_publicacion, titulo, descripcion, archivo, portada, seccion)

4. **Trivias (Juegos/Cuestionarios)**
   - Hub principal: `Trivias.php` (muestra 6 opciones de juegos + ranking)
   - Juegos:
     - **J1**: Juego de memoria con cartas (usa tabla `orden_cartas`)
     - **J2**: Cuestionario de opción múltiple (usa tabla `test`)
     - **J3**: Contenido educativo con cuestionario (estilo flappy bird, tabla `avion`)
     - **J4**: Ahorcado - adivinanza de palabras (tabla `ahorcados`)
     - **J5**: Juego de ordenar/selección de texto (tabla `fov` - Falso o Verdadero)
     - **J6**: Sopa de letras (`SopaLetras/index.html`)
   - Versiones admin: `J1Adm.php`, `J2Adm.php`, `J3Adm.php`, `J4Adm.php`, `J5Adm.php`, `J6Adm.php`
   - Puntuación: Cada juego actualiza los puntos del usuario en la tabla `perfil` mediante scripts PHP dedicados en `PHP/`

5. **Perfil de Usuario**
   - Vista/Edición: `Cuenta.php`
   - Backend: `PHP/guardar_perfil.php`, `PHP/cambioPerfil.php`
   - Tablas de base de datos: `usuarios` (id, nombre_usuario, correo, clave, rol_id, fecha) unido con `perfil` (id, puntos*, avatarImg)

### Sistema de Ranking

- Se muestra en la barra lateral de trivias mediante `JS/rank.js`
- Backend: `PHP/getRanking.php`
- Agrega puntos de múltiples columnas de juegos en la tabla `perfil`:
  - `puntos` (general/J2), `puntos_cartas` (J1), `puntos_avion` (J3), `puntos_ahorcados` (J4), `puntos_fov` (J5), `puntos_seleccion` (J6)
- Funcionalidad de reinicio: `PHP/resetCounters*.php` y `PHP/resetPoints.php`

### Componentes Compartidos (PHP Includes)

- `header_info.php`: Barra de información superior con enlaces de contacto/redes sociales
- `header_section.php`: Sección hero para páginas principales
- `header_section_news.php`: Sección hero para páginas de noticias
- `main_menu.php`: Menú de navegación público
- `main_menu_user.php`: Navegación de usuario autenticado (incluye dropdown de cuenta)
- `main_menu_single.php`: Variante de navegación de página única
- `footer.php`: Pie de página con enlaces y créditos
- `modal_iniciar.php`: Modal de inicio de sesión
- `modal_registro.php`: Modal de registro
- `modal_cierre.php`: Modal de confirmación de cierre de sesión
- `mensaje_calculadora.php`: Sección promocional de la calculadora
- `apoyo.php`: Sección de logos de apoyo/patrocinadores
- `PHP/popups.php`: Funcionalidad reutilizable de popup/modal
- `PHP/direcciones.php`: Configuración de URLs/rutas

## Organización de Archivos

```
/
├── PHP/                    # Scripts del backend
│   ├── conexionBe.php      # Conexión a base de datos (gitignored)
│   ├── config.php          # Credenciales por defecto (gitignored)
│   ├── *Be.php             # Manejadores de formularios (login, registro, etc.)
│   ├── obtener*.php        # Scripts de obtención de datos
│   ├── actualizar*.php     # Scripts de actualización de datos
│   └── subir*.php          # Manejadores de carga de archivos
├── JS/                     # Archivos JavaScript
│   ├── script*.js          # Scripts específicos de página
│   ├── bootstrap.min.js    # Framework Bootstrap
│   └── jquery.min.js       # Biblioteca jQuery
├── css/                    # Hojas de estilo
│   ├── bootstrap.min.css
│   ├── bootstrap-icons.css
│   └── templatemo-kind-heart-charity.css
├── assets/CSS/             # Estilos personalizados adicionales
├── images/                 # Imágenes de plantilla y logos
├── IMG/                    # Imágenes subidas por usuarios y de juegos
├── IMGUP/                  # Destino de cargas (gitignored)
├── IMGPR/                  # Imágenes de publicaciones
├── PDF/                    # Publicaciones PDF (gitignored)
├── video/                  # Archivos de video (gitignored)
├── SopaLetras/             # Juego de sopa de letras (independiente)
├── BirdGame/               # Assets del juego flappy bird
├── *.php                   # Páginas principales de la aplicación
└── Calculadora*.html       # Páginas de la calculadora hídrica
```

## Flujo de Trabajo de Desarrollo

### Ejecutar la Aplicación

1. Asegurar que XAMPP esté ejecutándose (Apache + MySQL)
2. Navegar a `http://localhost/terraco/` (redirige a `SinLogin.php` vía `.htaccess`)
3. Credenciales de admin por defecto en `PHP/config.php`: `FundGaiaPacha` / `GaiaPacha2023`

### Tareas Comunes de Desarrollo

**Agregar un nuevo juego/trivia:**
1. Crear página principal: `J{N}.php` (copiar estructura de archivos J existentes)
2. Crear página admin: `J{N}Adm.php`
3. Agregar tabla de base de datos para contenido del juego
4. Crear script de actualización de puntaje: `PHP/actualizarPuntuacion{NombreJuego}.php`
5. Agregar columna a la tabla `perfil` para puntos específicos del juego
6. Actualizar `Trivias.php` para incluir la tarjeta del nuevo juego
7. Actualizar `PHP/getRanking.php` para incluir la nueva columna de puntos

**Agregar una noticia (vía admin):**
1. Iniciar sesión como admin → Navegar a `NoticiasAdm.php`
2. Usar formulario de carga (manejado por `PHP/subir_noticias.php`)
3. Imágenes almacenadas en `IMGUP/`, referenciadas en tabla `noticias`

**Modificar la calculadora hídrica:**
1. Páginas HTML: `CalculadoraPag*.html`
2. JS correspondiente: `JS/scriptCalPag*.js`
3. Lógica de cálculo típicamente en página final (`CalculadoraPagFinal.html`)

### Notas sobre el Esquema de Base de Datos

Tablas clave:
- `usuarios`: id (FK a perfil), nombre_usuario, correo, clave (SHA-512), rol_id (FK a cargo), fecha
- `cargo`: id, descripcion (roles: Administrador, Usuario)
- `perfil`: id (PK, compartido con usuarios), puntos, puntos_cartas, puntos_avion, puntos_ahorcados, puntos_fov, puntos_seleccion, avatarImg
- `noticias`: id_noticia, titulo_noticia, descripcion_noticia, imagen_noticia, creacion_noticia, noticia_destacada
- `publicacion`: id_publicacion, titulo, descripcion, archivo (ruta PDF), portada (ruta imagen), seccion (1/2/3)
- `test`: id, pregunta, opcion1-4, imagen, resultado
- `orden_cartas`: id, rutaImagen, orden
- `avion`: id, titulo, texto, texto2, estado
- `ahorcados`: id, nombre, imagen, respuesta, pista
- `fov`: id, texto, imagen, correcta (boolean)

## Consideraciones de Seguridad

**PROBLEMAS CRÍTICOS** (no corregir sin autorización explícita, solo documentar):
1. **Inyección SQL**: Todas las entradas de usuario en archivos `PHP/*Be.php` usan concatenación de strings en lugar de declaraciones preparadas
2. **XSS**: No hay escape de salida en renderizado de contenido dinámico
3. **Seguridad de Sesión**: Sin protección CSRF, vulnerabilidades de fijación de sesión
4. **Almacenamiento de Contraseñas**: SHA-512 sin sal (mejor que texto plano, pero no bcrypt/Argon2)
5. **Carga de Archivos**: Validación limitada en scripts de carga

Al realizar cambios:
- Mantener los patrones de autenticación existentes a menos que se asigne específicamente mejoras de seguridad
- Probar con ambos roles: Administrador y Usuario
- Verificar que las redirecciones de sesión funcionen correctamente
- Revisar `.gitignore` antes de hacer commit para evitar exponer credenciales

## Estilo de Código

- PHP: HTML en línea con bloques `<?php ?>` (patrón legacy, no MVC)
- JavaScript: Sintaxis ES5, uso intensivo de jQuery
- CSS: Utilidades Bootstrap + sobreescrituras personalizadas en `templatemo-kind-heart-charity.css`
- Indentación: Mixta (2-4 espacios, algunos tabs) - coincidir con el código circundante
- Nomenclatura de archivos: PascalCase para páginas (ej., `ConLogin.php`), camelCase para scripts (ej., `scriptLog.js`)

## Flujo de Trabajo Git

Rama actual: `kindHerat`
Rama principal: No configurada (verificar antes de crear PRs)

Archivos modificados en el árbol de trabajo:
- `PHP/conexionBe.php` (cambios sin commit)

Siempre verificar `git status` antes de hacer commit. Patrón común de commit:
```
git add .
git commit -m "Descripción del cambio"
```
