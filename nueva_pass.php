<?php
include 'config/database.php';

// Verifica si se recibió un token válido
if (isset($_GET['token'])) {
    $token = $mysqli->real_escape_string($_GET['token']);

    // Consulta para verificar el token
    $query = "SELECT email FROM password_resets WHERE token = '$token' AND created_at > NOW() - INTERVAL 1 HOUR";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtiene la nueva contraseña y su confirmación
            $new_pass = $mysqli->real_escape_string($_POST['new_pass']);
            $retype_pass = $mysqli->real_escape_string($_POST['retype_pass']);

            // Verifica si las contraseñas coinciden
            if ($new_pass !== $retype_pass) {
                header("Location: nueva_pass.php?token=$token&alert=2");
                exit();
            }

            // Verifica si la nueva contraseña es diferente a la anterior
            $userQuery = "SELECT password FROM usuarios WHERE email = '$email'";
            $userResult = $mysqli->query($userQuery);
            $userRow = $userResult->fetch_assoc();

            if (md5($new_pass) === $userRow['password']) {
                header("Location: nueva_pass.php?token=$token&alert=1");
                exit();
            }

            // Cifra la nueva contraseña con MD5
            $hashed_password = md5($new_pass);

            // Actualiza la contraseña en la base de datos
            $updateQuery = "UPDATE usuarios SET password = '$hashed_password' WHERE email = '$email'";
            if ($mysqli->query($updateQuery)) {
                // Redirige a la página de éxito después de actualizar la contraseña
                header("Location: nueva_pass.php?token=$token&alert=3");
                exit();
            } else {
                echo "Error al actualizar la contraseña: " . $mysqli->error;
            }
        }
    } else {
        // Si el token es inválido o ha expirado, redirige con mensaje de error
        header("Location: nueva_pass.php?alert=4");
        exit();
    }
} else {
    // Redirige si no se recibe un token válido
    header("Location: nueva_pass.php?alert=5");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Mostrar mensajes de error -->
                <?php
                if (!empty($_GET['alert'])) {
                    if ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> La contraseña nueva no puede ser igual a la anterior.
                            </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> Las contraseñas no coinciden.
                            </div>";
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <strong><i class='fa-solid fa-circle-check'></i> Éxito:</strong> Contraseña actualizada exitosamente. <a href='index.php'>Inicia sesión</a>
                            </div>";
                    } elseif ($_GET['alert'] == 4) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> El token es inválido o ha expirado.
                            </div>";
                    } elseif ($_GET['alert'] == 5) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> Acceso denegado.
                            </div>";
                    }
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cambiar Contraseña</h3>
                    </div>
                    <form role="form" method="POST" action="">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label" for="new_pass">Contraseña nueva</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="new_pass" name="new_pass"
                                        autocomplete="off" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label" for="retype_pass">Repetir nueva contraseña</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="retype_pass" name="retype_pass"
                                        autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Si la URL contiene el parámetro 'alert=3', esto indica éxito
        if (window.location.href.indexOf("alert=3") > -1) {
            // Espera 10 segundos antes de cerrar la página
            setTimeout(function() {
                window.close();  // Cierra la ventana actual
            }, 5000); // 5000 ms = 5 segundos
        }
    </script>
</body>
</html>
