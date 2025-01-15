<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="descripcion" content="sysweb">
    <meta name="autor" content="Carlos Ortiz">
    <title>Proyecto</title>

    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="dist/css/coreui.min.css" rel="stylesheet">
    <link href="dist/css/themes/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/black_smoke.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
</head>

<body class="app">
    <div class="wrapper">
        <header class="header header-sticky header-dark ">
            <nav class="navbar navbar-dark bg-dark fixed-top">
                <div class="container-fluid">
                    <button class="navbar-toggler smoke-bg" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="sidebar-brand bar">
                        <a class="sidebar-brand-full" href="#">
                            <img src="images/favicon.ico" alt="logo sysweb">
                        </a>
                    </div>
                    <div class="header-nav">
                        <ul class="header-nav ms-auto">
                            <?php include 'top-menu.php' ?>
                        </ul>
                    </div>
                    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="1" id="offcanvasDarkNavbar"
                        aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="?module=start">Inicio</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Referenciales Generales
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="?module=departamento">Departamento</a></li>
                                        <li><a class="dropdown-item" href="?module=ciudad">Ciudad</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    </ul>
                                </li>

                                <?php
                                // Verificar los permisos del usuario desde la sesión
                                $current_access = $_SESSION['permisos_acceso']; // Asumiendo que 'permisos_acceso' contiene el rol

                                // Mostrar el menú de "Referenciales Compras" solo si el usuario es 'Compras' o 'Super Admin'
                                if ($current_access == 'Super Admin' || $current_access == 'Compras') {
                                ?>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Informes de compra
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="?module=info_nota">Informes de notas de crédito y débito</a></li>
                                            <li><a class="dropdown-item" href="?module=info_orden">Informes de ordenes de compra</a></li>
                                            <li><a class="dropdown-item" href="?module=info_pedido">Informes de pedidos</a></li>
                                            <li><a class="dropdown-item" href="?module=info_presu">Informes de presupuesto</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Referenciales Compras
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="?module=deposito">Deposito</a></li>
                                            <li><a class="dropdown-item" href="?module=proveedor">Proveedor</a></li>
                                            <li><a class="dropdown-item" href="?module=producto">Producto</a></li>
                                            <li><a class="dropdown-item" href="?module=tipo_producto">Tipo de producto</a></li>
                                            <li><a class="dropdown-item" href="?module=u_medida">Unidad de medida</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php
                                // Mostrar el menú de "Referenciales Ventas" solo si el usuario es 'Ventas' o 'Super Admin'
                                if ($current_access == 'Super Admin' || $current_access == 'Ventas') {
                                ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Referenciales Ventas
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="?module=clientes">Clientes</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <li class="nav-item">
                                    <a class="nav-link" href="?module=password">Cambiar Contraseña</a>
                                </li>

                                <?php
                                // Mostrar el menú de "Administrar Usuario" solo si el usuario es 'Super Admin'
                                if ($current_access == 'Super Admin') {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?module=user">Administrar Usuario</a>
                                    </li>
                                <?php } ?>

                                <li class="nav-item">
                                    <a class="nav-link" href="config/Manual de usuario.pdf" target="new">Manual de usuario</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="main">
            <main class="container-fluid">
                <?php
                include 'content.php';
                ?>
                <div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="logoutLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutLabel"><i class="fa fa-sign-out"></i> Cerrar sesión
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres cerrar la sesión?</p>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-danger" href="logout.php">Sí, salir</a>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer">
                <strong>Copyright &copy; <?php echo date('Y'); ?> - Desarrollado por Black Smoke S.A.</strong>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/coreui.min.js"
        integrity="sha384-c4nHOtHRPhkHqJsqK5SH1UkyoL2HUUhzGfzGkchJjwIrAlaYVBv+yeU8EYYxW6h5"
        crossorigin="anonymous"></script>
</body>

</html>