<?php
// Requiere PHPMailer (usa Composer o descárgalo manualmente)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Incluye la conexión a la base de datos
include 'config/database.php';

if (isset($_POST['email'])) {
    $email = $mysqli->real_escape_string($_POST['email']);

    // Verifica si el correo está registrado
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // Genera un token único
        $token = bin2hex(random_bytes(32));

        // Guarda el token en la base de datos
        $mysqli->query("INSERT INTO password_resets (email, token) VALUES ('$email', '$token')");

        // Prepara el enlace
        $resetLink = "http://localhost/proyecto_mt/nueva_pass.php?token=$token";

        // Enviar el correo
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia si usas otro servidor SMTP o MailHog
            $mail->SMTPAuth = true;
            $mail->Username = 'emanuelortizferreiracarlos546@gmail.com'; // Tu correo
            $mail->Password = 'tbsdqjophfyxzjtx'; // Contraseña o contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Cambia si usas otro puerto SMTP

            // Configuración de codificación
            $mail->CharSet = 'UTF-8'; // Asegura que use UTF-8 para caracteres especiales

            // Configuración del correo
            //To load the spanish version
            $mail->setLanguage('es', 'vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php');
            $mail->setFrom('emanuelortizferreiracarlos546@gmail.com', 'Carlos Emanuel Ortiz Ferreira');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Restablecer contraseña';
            $mail->Body = "
                <h3>Solicitud de restablecimiento de contraseña</h3>
                <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el botón de abajo para cambiarla:</p>
                <a href='$resetLink' style='display: inline-block; padding: 10px 15px; background-color: #3c8dbc; color: white; text-decoration: none; border-radius: 5px;'>Cambiar contraseña</a>
                <p>Si no solicitaste este cambio, simplemente ignora este correo.</p>
            ";

            $mail->send();

            // Redirige con éxito
            header("Location: index.php?alert=5");
        } catch (Exception $e) {
            // Error al enviar
            header("Location: index.php?alert=6 {$mail->ErrorInfo}");
        }
    } else {
        // Correo no registrado
        header("Location: index.php?alert=4");
    }
    exit();
}
?>
