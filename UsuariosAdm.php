<?php
session_start();
$roles_permitidos = ['Administrador'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ConLogin.php");
    die();
}

include "PHP/conexionBe.php";

// Parámetros de filtro
$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';
$filtro_estado = isset($_GET['estado']) ? $_GET['estado'] : 'todos';
$filtro_rol = isset($_GET['rol']) ? $_GET['rol'] : 'todos';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 20;
$offset = ($pagina - 1) * $por_pagina;

// Construir consulta WHERE
$where = "1=1";
if (!empty($buscar)) {
    $where .= " AND (u.nombre_usuario LIKE '%$buscar%' OR u.correo LIKE '%$buscar%' OR u.nombre_completo LIKE '%$buscar%')";
}
if ($filtro_estado === 'activos') {
    $where .= " AND u.activo = 1";
} elseif ($filtro_estado === 'inactivos') {
    $where .= " AND u.activo = 0";
}
if ($filtro_rol === 'admin') {
    $where .= " AND c.descripcion = 'Administrador'";
} elseif ($filtro_rol === 'usuario') {
    $where .= " AND c.descripcion = 'Usuario'";
}

// Consulta principal
$query = "SELECT u.id, u.nombre_usuario, u.nombre_completo, u.correo, u.fecha, u.activo, u.institucion, c.descripcion as rol
    FROM usuarios u
    LEFT JOIN cargo c ON u.rol_id = c.id
    WHERE $where
    ORDER BY u.fecha DESC
    LIMIT $offset, $por_pagina";
$resultado = mysqli_query($conexion, $query);

// Contar total
$query_count = "SELECT COUNT(*) as total FROM usuarios u LEFT JOIN cargo c ON u.rol_id = c.id WHERE $where";
$resultado_count = mysqli_query($conexion, $query_count);
$total = mysqli_fetch_assoc($resultado_count)['total'];
$total_paginas = ceil($total / $por_pagina);

// Estadísticas
$query_stats = "SELECT
    COUNT(*) as total_usuarios,
    SUM(activo = 1) as total_activos,
    SUM(activo = 0) as total_inactivos,
    (SELECT COUNT(*) FROM usuarios u2 INNER JOIN cargo c2 ON u2.rol_id = c2.id WHERE c2.descripcion = 'Administrador') as total_admins
    FROM usuarios";
$stats = mysqli_fetch_assoc(mysqli_query($conexion, $query_stats));

// Mensaje de acción
$mensaje = '';
$tipo_mensaje = '';
if (isset($_GET['activado'])) {
    $mensaje = 'Usuario activado correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['desactivado'])) {
    $mensaje = 'Usuario desactivado correctamente.';
    $tipo_mensaje = 'warning';
} elseif (isset($_GET['rol_cambiado'])) {
    $rol_nuevo = $_GET['rol_cambiado'] == 'admin' ? 'Administrador' : 'Usuario';
    $mensaje = "Rol cambiado a $rol_nuevo correctamente.";
    $tipo_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    $errores = [
        'parametros' => 'Parametros invalidos.',
        'automodificacion' => 'No puedes desactivarte o quitarte el rol de administrador a ti mismo.',
        'accion_invalida' => 'Accion no reconocida.',
        'db' => 'Error de base de datos.'
    ];
    $mensaje = isset($errores[$_GET['error']]) ? $errores[$_GET['error']] : 'Error desconocido.';
    $tipo_mensaje = 'danger';
}

// Obtener ID del usuario actual para evitar automodificación
$usuario_actual = $_SESSION['usuario'];
$query_actual = "SELECT id FROM usuarios WHERE nombre_usuario = '$usuario_actual'";
$resultado_actual = mysqli_query($conexion, $query_actual);
$usuario_actual_id = 0;
if ($resultado_actual && mysqli_num_rows($resultado_actual) > 0) {
    $usuario_actual_id = mysqli_fetch_assoc($resultado_actual)['id'];
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Administracion de Usuarios">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Gestion de Usuarios - Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!-- CSS Especifico Usuarios Admin -->
    <link href="assets/CSS/styleUsrAdm.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body id="section_1">

<?php include "header_info.php"; ?>
<?php include "main_menu_user.php"; ?>

<main>
    <!-- BREADCRUMB -->
    <section class="section-padding-top" style="padding-top: 30px;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="ConLoginAdm.php">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-4">Gestion de Usuarios</h2>

            <?php if (!empty($mensaje)) { ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-primary"><?php echo $stats['total_usuarios'] ?: 0; ?></h3>
                        <p class="mb-0">Total Usuarios</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-success"><?php echo $stats['total_activos'] ?: 0; ?></h3>
                        <p class="mb-0">Activos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-danger"><?php echo $stats['total_inactivos'] ?: 0; ?></h3>
                        <p class="mb-0">Inactivos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-info"><?php echo $stats['total_admins'] ?: 0; ?></h3>
                        <p class="mb-0">Administradores</p>
                    </div>
                </div>
            </div>

            <!-- Barra de búsqueda y filtros -->
            <div class="filtros-container">
                <form action="UsuariosAdm.php" method="get" class="row g-3">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="buscar" placeholder="Buscar por nombre, correo..." value="<?php echo htmlspecialchars($buscar); ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <select class="form-select" name="estado">
                            <option value="todos" <?php echo $filtro_estado == 'todos' ? 'selected' : ''; ?>>Todos los estados</option>
                            <option value="activos" <?php echo $filtro_estado == 'activos' ? 'selected' : ''; ?>>Solo activos</option>
                            <option value="inactivos" <?php echo $filtro_estado == 'inactivos' ? 'selected' : ''; ?>>Solo inactivos</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <select class="form-select" name="rol">
                            <option value="todos" <?php echo $filtro_rol == 'todos' ? 'selected' : ''; ?>>Todos los roles</option>
                            <option value="admin" <?php echo $filtro_rol == 'admin' ? 'selected' : ''; ?>>Solo Admin</option>
                            <option value="usuario" <?php echo $filtro_rol == 'usuario' ? 'selected' : ''; ?>>Solo Usuario</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de usuarios -->
            <div class="table-responsive custom-text-box">
                <table class="table table-hover table-usuarios">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th class="col-fecha">Fecha</th>
                            <th>Institución</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while ($usuario = mysqli_fetch_assoc($resultado)) {
                                $es_usuario_actual = ($usuario['id'] == $usuario_actual_id);
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></strong>
                                    <?php if ($es_usuario_actual) { ?>
                                    <span class="badge bg-info ms-1">Tu</span>
                                    <?php } ?>
                                </td>
                                <td class="usuario-info"><?php echo htmlspecialchars($usuario['nombre_completo'] ?: '-'); ?></td>
                                <td class="usuario-info"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td class="col-fecha"><?php echo date('d/m/Y', strtotime($usuario['fecha'])); ?></td>
                                <td class="usuario-info"><?php echo htmlspecialchars($usuario['institucion'] ?: '-'); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Indicador de estado -->
                                        <?php if ($usuario['activo']) { ?>
                                        <span class="btn btn-sm btn-estado-activo" title="Activo"><i class="fas fa-circle"></i></span>
                                        <?php } else { ?>
                                        <span class="btn btn-sm btn-estado-inactivo" title="Inactivo"><i class="fas fa-circle"></i></span>
                                        <?php } ?>
                                        <!-- Activar/Desactivar -->
                                        <?php if ($usuario['activo']) { ?>
                                            <?php if (!$es_usuario_actual) { ?>
                                            <a href="PHP/usuarios_actualizar.php?id=<?php echo $usuario['id']; ?>&accion=desactivar"
                                               class="btn btn-outline-danger btn-accion" title="Desactivar usuario"
                                               onclick="return confirm('¿Desactivar este usuario?');">
                                                <i class="fas fa-eye-slash"></i>
                                            </a>
                                            <?php } else { ?>
                                            <button class="btn btn-outline-secondary btn-accion" disabled title="No puedes desactivarte">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                            <?php } ?>
                                        <?php } else { ?>
                                        <a href="PHP/usuarios_actualizar.php?id=<?php echo $usuario['id']; ?>&accion=activar"
                                           class="btn btn-outline-success btn-accion" title="Activar usuario">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php } ?>

                                        <!-- Cambiar rol -->
                                        <?php if ($usuario['rol'] == 'Administrador') { ?>
                                            <?php if (!$es_usuario_actual) { ?>
                                            <a href="PHP/usuarios_actualizar.php?id=<?php echo $usuario['id']; ?>&accion=rol_usuario"
                                               class="btn btn-outline-secondary btn-accion" title="Cambiar a Usuario"
                                               onclick="return confirm('¿Cambiar rol a Usuario?');">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            <?php } else { ?>
                                            <button class="btn btn-outline-secondary btn-accion" disabled title="No puedes quitarte el rol de admin">
                                                <i class="fas fa-user"></i>
                                            </button>
                                            <?php } ?>
                                        <?php } else { ?>
                                        <a href="PHP/usuarios_actualizar.php?id=<?php echo $usuario['id']; ?>&accion=rol_admin"
                                           class="btn btn-outline-primary btn-accion" title="Cambiar a Administrador"
                                           onclick="return confirm('¿Cambiar rol a Administrador?');">
                                            <i class="fas fa-user-shield"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">No se encontraron usuarios.</p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Info de paginación y paginación -->
            <?php if ($total > 0) { ?>
            <div class="row mt-4 align-items-center">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <p class="pagination-info mb-0">
                        Mostrando <?php echo $offset + 1; ?>-<?php echo min($offset + $por_pagina, $total); ?> de <?php echo $total; ?> usuarios
                    </p>
                </div>
                <div class="col-md-6 col-12">
                    <?php if ($total_paginas > 1) { ?>
                    <nav>
                        <ul class="pagination justify-content-md-end justify-content-center mb-0">
                            <?php if ($pagina > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="UsuariosAdm.php?pagina=<?php echo $pagina - 1; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?><?php echo $filtro_estado != 'todos' ? '&estado=' . $filtro_estado : ''; ?><?php echo $filtro_rol != 'todos' ? '&rol=' . $filtro_rol : ''; ?>">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <?php } ?>

                            <?php
                            // Mostrar máximo 5 páginas
                            $inicio_pag = max(1, $pagina - 2);
                            $fin_pag = min($total_paginas, $pagina + 2);

                            if ($inicio_pag > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="UsuariosAdm.php?pagina=1<?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?><?php echo $filtro_estado != 'todos' ? '&estado=' . $filtro_estado : ''; ?><?php echo $filtro_rol != 'todos' ? '&rol=' . $filtro_rol : ''; ?>">1</a>
                            </li>
                            <?php if ($inicio_pag > 2) { ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php } ?>
                            <?php } ?>

                            <?php for ($i = $inicio_pag; $i <= $fin_pag; $i++) { ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="UsuariosAdm.php?pagina=<?php echo $i; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?><?php echo $filtro_estado != 'todos' ? '&estado=' . $filtro_estado : ''; ?><?php echo $filtro_rol != 'todos' ? '&rol=' . $filtro_rol : ''; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($fin_pag < $total_paginas) { ?>
                            <?php if ($fin_pag < $total_paginas - 1) { ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php } ?>
                            <li class="page-item">
                                <a class="page-link" href="UsuariosAdm.php?pagina=<?php echo $total_paginas; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?><?php echo $filtro_estado != 'todos' ? '&estado=' . $filtro_estado : ''; ?><?php echo $filtro_rol != 'todos' ? '&rol=' . $filtro_rol : ''; ?>"><?php echo $total_paginas; ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($pagina < $total_paginas) { ?>
                            <li class="page-item">
                                <a class="page-link" href="UsuariosAdm.php?pagina=<?php echo $pagina + 1; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?><?php echo $filtro_estado != 'todos' ? '&estado=' . $filtro_estado : ''; ?><?php echo $filtro_rol != 'todos' ? '&rol=' . $filtro_rol : ''; ?>">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</main>

<?php include "footer.php"; ?>
<?php include "modal_cierre.php"; ?>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>

</body>

</html>
<?php mysqli_close($conexion); ?>
