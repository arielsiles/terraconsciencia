<?php
// Cargar configuración de reCAPTCHA si existe
$recaptchaSiteKey = '';
$configPath = __DIR__ . '/PHP/config_email.php';
if (file_exists($configPath)) {
    require_once $configPath;
    if (defined('RECAPTCHA_SITE_KEY')) {
        $recaptchaSiteKey = RECAPTCHA_SITE_KEY;
    }
}
?>
<!-- Modal de registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">REGISTRARSE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenedor para mensajes de error/éxito -->
                <div id="registro-alert" class="alert d-none" role="alert"></div>

                <form id="form-registro" action="PHP/registroUsuarioBe.php" method="POST" class="sign-up-form">
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_usuario_reg" class="form-label">Nombre de usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_usuario_reg" name="nombre_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave_reg" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="clave_reg" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="institucion" class="form-label">Institución a la que perteneces <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ej: Universidad Mayor de San Andrés" required>
                    </div>
                    <?php if (!empty($recaptchaSiteKey)): ?>
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>
                    </div>
                    <?php endif; ?>
                    <button type="submit" class="custom-btn" id="btn-registro">Registrarse</button>
                </form>
                <p class="mt-3">¿YA TIENES CUENTA? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">INICIAR SESIÓN</a></p>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($recaptchaSiteKey)): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var formRegistro = document.getElementById('form-registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            e.preventDefault();

            var alertBox = document.getElementById('registro-alert');
            var btnRegistro = document.getElementById('btn-registro');
            var btnTextoOriginal = btnRegistro.innerHTML;

            // Ocultar alerta anterior
            alertBox.classList.add('d-none');
            alertBox.classList.remove('alert-danger', 'alert-success');

            // Deshabilitar botón mientras procesa
            btnRegistro.disabled = true;
            btnRegistro.innerHTML = 'Procesando...';

            var formData = new FormData(formRegistro);

            fetch('PHP/registroUsuarioBe.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Éxito: mostrar mensaje y redirigir
                    alertBox.classList.remove('d-none', 'alert-danger');
                    alertBox.classList.add('alert-success');
                    alertBox.innerHTML = data.message;

                    if (data.redirect) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                } else {
                    // Error: mostrar mensaje en el modal
                    alertBox.classList.remove('d-none', 'alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.innerHTML = data.message;

                    // Rehabilitar botón
                    btnRegistro.disabled = false;
                    btnRegistro.innerHTML = btnTextoOriginal;

                    // Resetear reCAPTCHA si existe
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                }
            })
            .catch(function(error) {
                // Error de red o parsing
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.innerHTML = 'Error de conexión. Por favor, intente nuevamente.';

                btnRegistro.disabled = false;
                btnRegistro.innerHTML = btnTextoOriginal;

                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            });
        });
    }
});
</script>
