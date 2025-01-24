<!-- Modal de registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">REGISTRARSE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="PHP/registroUsuarioBe.php" method="POST" class="sign-up-form">
                    <div class="mb-3"> <label for="nombre_usuario_reg" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario_reg" name="nombre_usuario" required>
                    </div>
                    <div class="mb-3"> <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3"> <label for="clave_reg" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave_reg" name="clave" required>
                    </div>
                    <button type="submit" class="custom-btn">Registrarse</button>
                </form>
                <p class="mt-3">¿YA TIENES CUENTA? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">INICIAR SESIÓN</a></p>
            </div>
        </div>
    </div>
</div>