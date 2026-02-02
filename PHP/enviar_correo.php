<?php
/**
 * Funciones de envío de correo electrónico
 * Terra ConsCiencia
 *
 * Usa PHPMailer para enviar emails via SMTP
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/config_email.php';

/**
 * Envía un correo electrónico usando PHPMailer
 *
 * @param string $destinatario Email del destinatario
 * @param string $asunto Asunto del correo
 * @param string $cuerpoHtml Contenido HTML del correo
 * @param string $cuerpoTexto Contenido de texto plano (fallback)
 * @return array ['success' => bool, 'message' => string]
 */
function enviarCorreo($destinatario, $asunto, $cuerpoHtml, $cuerpoTexto = '') {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        // Remitente y destinatario
        $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
        $mail->addAddress($destinatario);

        // Contenido del email
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpoHtml;
        $mail->AltBody = $cuerpoTexto ?: strip_tags($cuerpoHtml);

        $mail->send();
        return ['success' => true, 'message' => 'Correo enviado exitosamente'];

    } catch (Exception $e) {
        return ['success' => false, 'message' => "Error al enviar correo: {$mail->ErrorInfo}"];
    }
}

/**
 * Envía el correo de confirmación de cuenta
 *
 * @param string $destinatario Email del usuario
 * @param string $nombreUsuario Nombre del usuario
 * @param string $token Token de confirmación
 * @return array ['success' => bool, 'message' => string]
 */
function enviarCorreoConfirmacion($destinatario, $nombreUsuario, $token) {
    $linkConfirmacion = SITE_URL . "/PHP/confirmar_cuenta.php?token=" . urlencode($token);

    $asunto = "Confirma tu cuenta - Terra ConsCiencia";

    $cuerpoHtml = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
            <tr>
                <td align="center">
                    <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <!-- Header -->
                        <tr>
                            <td style="background-color: #198754; padding: 30px 40px; text-align: center;">
                                <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Terra ConsCiencia</h1>
                                <p style="color: #ffffff; margin: 10px 0 0 0; opacity: 0.9;">Plataforma Educativa Ambiental</p>
                            </td>
                        </tr>
                        <!-- Content -->
                        <tr>
                            <td style="padding: 40px;">
                                <h2 style="color: #333333; margin: 0 0 20px 0;">¡Hola, ' . htmlspecialchars($nombreUsuario) . '!</h2>
                                <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                    Gracias por registrarte en Terra ConsCiencia. Para completar tu registro y activar tu cuenta, haz clic en el siguiente enlace:
                                </p>
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 30px auto;">
                                    <tr>
                                        <td style="background-color: #198754; border-radius: 6px;">
                                            <a href="' . $linkConfirmacion . '" style="display: inline-block; padding: 15px 40px; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold;">
                                                Activar mi cuenta
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <p style="color: #555555; font-size: 14px; line-height: 1.6; margin: 20px 0;">
                                    Si el enlace no funciona, copia y pega la siguiente URL en tu navegador:
                                </p>
                                <p style="color: #198754; font-size: 12px; word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 4px;">
                                    ' . $linkConfirmacion . '
                                </p>
                                <p style="color: #888888; font-size: 13px; margin: 30px 0 0 0;">
                                    <strong>Nota:</strong> Este enlace expira en ' . TOKEN_EXPIRY_HOURS . ' horas.
                                </p>
                            </td>
                        </tr>
                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #f8f9fa; padding: 20px 40px; text-align: center; border-top: 1px solid #eeeeee;">
                                <p style="color: #888888; font-size: 12px; margin: 0;">
                                    Si no solicitaste esta cuenta, puedes ignorar este correo.
                                </p>
                                <p style="color: #888888; font-size: 12px; margin: 10px 0 0 0;">
                                    &copy; ' . date('Y') . ' Terra ConsCiencia - Fundacion Gaia Pacha
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    $cuerpoTexto = "Hola $nombreUsuario,\n\n";
    $cuerpoTexto .= "Gracias por registrarte en Terra ConsCiencia.\n\n";
    $cuerpoTexto .= "Para activar tu cuenta, visita el siguiente enlace:\n";
    $cuerpoTexto .= "$linkConfirmacion\n\n";
    $cuerpoTexto .= "Este enlace expira en " . TOKEN_EXPIRY_HOURS . " horas.\n\n";
    $cuerpoTexto .= "Si no solicitaste esta cuenta, puedes ignorar este correo.\n\n";
    $cuerpoTexto .= "Terra ConsCiencia - Fundacion Gaia Pacha";

    return enviarCorreo($destinatario, $asunto, $cuerpoHtml, $cuerpoTexto);
}

/**
 * Genera un token seguro para confirmación de cuenta
 *
 * @return string Token de 64 caracteres hexadecimales
 */
function generarToken() {
    return bin2hex(random_bytes(32));
}

/**
 * Calcula la fecha de expiración del token
 *
 * @return string Fecha en formato MySQL DATETIME
 */
function calcularExpiracionToken() {
    return date('Y-m-d H:i:s', strtotime('+' . TOKEN_EXPIRY_HOURS . ' hours'));
}
