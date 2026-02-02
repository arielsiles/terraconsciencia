<!-- Modal iniciar sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">INICIAR SESIÓN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="PHP/loginUsuarioBe.php" method="POST" class="sign-in-form">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo isset($config['default_user']) ? htmlspecialchars($config['default_user']) : ''; ?>">
                    </div>
                    <div class="mb-3"> <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" value="<?php echo isset($config['default_password']) ? htmlspecialchars($config['default_password']) : ''; ?>">
                    </div>
                    <button type="submit" class="custom-btn">Iniciar Sesión</button>
                </form>
                <p class="mt-3">¿NO TIENES CUENTA? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">REGISTRARSE</a></p>
            </div>
        </div>
    </div>
</div>