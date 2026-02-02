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
                    <div class="mb-2">
                        <label for="nombre_completo" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                    </div>
                    <div class="mb-2">
                        <label for="nombre_usuario_reg" class="form-label">Nombre de usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_usuario_reg" name="nombre_usuario"
                               required minlength="3" maxlength="20"
                               pattern="^[a-z0-9]{3,20}$"
                               title="3-20 caracteres, solo letras minúsculas y números"
                               autocomplete="username">
                        <small class="form-text text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-info-circle"></i> 3-20 caracteres, solo minúsculas y números
                        </small>
                    </div>
                    <div class="mb-2">
                        <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-2">
                        <label for="clave_reg" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="clave_reg" name="clave" required minlength="8"
                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                   title="Mínimo 8 caracteres, incluir mayúscula, minúscula y número">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <!-- Indicador de fortaleza -->
                        <div class="password-strength-container mt-1" id="password-strength-container" style="display: none;">
                            <div class="password-strength-bar" style="height: 4px; background-color: #e9ecef; border-radius: 3px; overflow: hidden;">
                                <div id="password-strength-fill" style="height: 100%; width: 0%; transition: all 0.3s ease;"></div>
                            </div>
                            <small id="password-strength-text" class="form-text"></small>
                        </div>
                        <small class="form-text text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-info-circle"></i> Mín. 8 caracteres: mayúscula, minúscula y número
                        </small>
                    </div>
                    <div class="mb-2">
                        <label for="institucion" class="form-label">Institución a la que perteneces <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ej: Universidad Mayor de San Andrés" required>
                    </div>
                    <?php if (!empty($recaptchaSiteKey)): ?>
                    <div class="mb-2">
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
    // Validación de nombre de usuario en tiempo real
    var usernameInput = document.getElementById('nombre_usuario_reg');
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            // Convertir a minúsculas y eliminar caracteres no permitidos
            this.value = this.value.toLowerCase().replace(/[^a-z0-9]/g, '');
        });
    }

    // Toggle mostrar/ocultar contraseña
    var togglePassword = document.getElementById('togglePassword');
    var passwordInput = document.getElementById('clave_reg');
    var toggleIcon = document.getElementById('togglePasswordIcon');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    }

    // Validación de fortaleza de contraseña en tiempo real
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            var password = this.value;
            var container = document.getElementById('password-strength-container');
            var fill = document.getElementById('password-strength-fill');
            var text = document.getElementById('password-strength-text');

            if (password.length === 0) {
                container.style.display = 'none';
                return;
            }

            container.style.display = 'block';

            // Calcular puntos de fortaleza
            var puntos = 0;
            var detalles = [];

            if (password.length >= 8) {
                puntos++;
            } else {
                detalles.push('8+ caracteres');
            }

            if (/[A-Z]/.test(password)) {
                puntos++;
            } else {
                detalles.push('mayúscula');
            }

            if (/[a-z]/.test(password)) {
                puntos++;
            } else {
                detalles.push('minúscula');
            }

            if (/[0-9]/.test(password)) {
                puntos++;
            } else {
                detalles.push('número');
            }

            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                puntos++;
            }

            if (password.length >= 12) {
                puntos++;
            }

            // Determinar nivel y color
            var nivel, color, porcentaje;
            if (puntos <= 2) {
                nivel = 'Débil';
                color = '#dc3545'; // rojo
                porcentaje = 33;
            } else if (puntos <= 4) {
                nivel = 'Media';
                color = '#ffc107'; // amarillo
                porcentaje = 66;
            } else {
                nivel = 'Fuerte';
                color = '#28a745'; // verde
                porcentaje = 100;
            }

            fill.style.width = porcentaje + '%';
            fill.style.backgroundColor = color;

            var mensaje = nivel;
            if (detalles.length > 0 && puntos < 4) {
                mensaje += ' - Falta: ' + detalles.join(', ');
            }
            text.textContent = mensaje;
            text.style.color = color;
        });
    }

    // Función de validación de contraseña
    function validarContrasena(password) {
        var errores = [];

        if (password.length < 8) {
            errores.push('mínimo 8 caracteres');
        }
        if (!/[A-Z]/.test(password)) {
            errores.push('al menos una mayúscula');
        }
        if (!/[a-z]/.test(password)) {
            errores.push('al menos una minúscula');
        }
        if (!/[0-9]/.test(password)) {
            errores.push('al menos un número');
        }

        return errores;
    }

    var formRegistro = document.getElementById('form-registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar contraseña antes de enviar
            var clave = document.getElementById('clave_reg').value;
            var erroresPassword = validarContrasena(clave);

            if (erroresPassword.length > 0) {
                var alertBox = document.getElementById('registro-alert');
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.innerHTML = 'La contraseña debe tener: ' + erroresPassword.join(', ');
                return;
            }

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
