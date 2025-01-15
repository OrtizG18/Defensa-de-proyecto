<html>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=yes">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="descripcion" content="sysweb">
        <meta name="autor" content="Carlos Ortiz">
        <title>Restablecer contraseña</title>

        <link rel="shortcut icon" href="images/favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="dist/css/black_smoke.css">
        <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/css/coreui.min.css" rel="stylesheet"
            integrity="sha384-u3h5SFn5baVOWbh8UkOrAaLXttgSF0vXI15ODtCSxl0v/VKivnCN6iHCcvlyTL7L" crossorigin="anonymous">
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
                    <!-- Login Form -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">
                                <i class="fa-solid fa-user"></i> Ingrese el correo para el restablecimiento de contraseña
                            </h5>
                            <form action="v_email.php" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electronico</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Email" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Enviar</button>
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