<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sysweb">
    <meta name="author" content="Aldo Torres">

    <link rel="shortcut icon" href="assets/img/favicon.ico" />
    <title>Sysweb - Login</title>

    <!-- CoreUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-u3h5SFn5baVOWbh8UkOrAaLXttgSF0vXI15ODtCSxl0v/VKivnCN6iHCcvlyTL7L" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/css/themes/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-nQQlHXZO4YmST3YDqk/JU3f1t2D58a/nPd1QbiLecouKn68glzRym4BlOxlr5Rrg" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">

</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img src="images/favicon.ico" alt="Sysweb" height="50">
                    <h1 style="color: #3c8dbc;">Sysweb</h1>
                </div>

                <!-- Alerts -->
                <?php
                if (!empty($_GET['alert'])) {
                    if ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-danger' role='alert'>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> Usuario o contraseña incorrecta.
                        </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-success' role='alert'>
                        <strong><i class='fa-solid fa-circle-check'></i> Salida Exitosa:</strong> Has cerrado tu sesión correctamente.
                        </div>";
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-warning' role='alert'>
                        <strong><i class='fa-solid fa-triangle-exclamation'></i> Atención:</strong> Por favor, ingresa un usuario y contraseña.
                        </div>";
                    }
                    elseif ($_GET['alert'] == 4) {
                        echo "<div class='alert alert-danger' role='alert'>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Error:</strong> El correo electronico ingresado no esta registrado
                        </div>";
                    } elseif ($_GET['alert'] == 5) {
                        echo "<div class='alert alert-success' role='alert'>
                        <strong><i class='fa-solid fa-circle-check'></i> Envio Exitoso:</strong> Se ha enviado el correo exitosamente
                        </div>";
                    } elseif ($_GET['alert'] == 6) {
                        echo "<div class='alert alert-warning' role='alert'>
                        <strong><i class='fa-solid fa-triangle-exclamation'></i> Atención:</strong> No se ha podido enviar el correo
                        </div>";
                    }
                }
                ?>

                <!-- Login Form -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">
                            <i class="fa-solid fa-user"></i> Por favor, inicie sesión
                        </h5>
                        <form action="login-check.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                            <hr>
                            <a href="restablecer_pass.php">¿Olvidaste tu contraseña?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CoreUI JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/coreui.min.js" integrity="sha384-c4nHOtHRPhkHqJsqK5SH1UkyoL2HUUhzGfzGkchJjwIrAlaYVBv+yeU8EYYxW6h5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-3sKEChMlWSojj7mapiBAXkrvOPKnTkBJ4sg4LIWclj3/6XkSkRzhnCp1EEgEcufO" crossorigin="anonymous"></script>
</body>

</html>