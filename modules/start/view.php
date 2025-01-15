<?php
if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="cil-home icon-title"></i> Inicio
        </h1>
        <ol class="breadcrumb ms-auto">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </div>
    <section class="content">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                <p style="font-size: 15px;">
                    <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                </p>
            </div>
        </div>
    </div>


        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 1 compras -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Compras</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Compra</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=compras" class="btn btn-light" title="Registrar compras" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 1 compras -->

            <!-- bloque 2 ventas -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ventas</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Ventas</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=ventas" class="btn btn-light" title="Registrar ventas" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 2 ventas -->

            <!-- bloque 3 stock -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Control de inventario</strong></h5>
                        <ul>
                            <li>Control</li>
                            <li>de</li>
                            <li>Inventario</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->

            <!-- bloque 4 pedido -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Pedido de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Pedido</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=pedido" class="btn btn-light" title="Ver pedidos de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 4 pedido -->

            <!-- bloque 5 presupuesto -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Presupuestos de proveedores</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Presupuestos</li>
                            <li>Proveedores</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=presupuesto" class="btn btn-light" title="Ver presupuestos de proveedores"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 5 presupuesto -->

            <!-- bloque 6 orden de compra -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ordenes de compra</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Ordenes</li>
                            <li>de compra</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=orden_compra" class="btn btn-light" title="Ver ordenes de compra"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 6 orden de compra -->

            <!-- bloque 6 Nota de credito y debito -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Notas de credito y debito</strong></h5>
                        <ul>
                            <li>Notas</li>
                            <li>Credito</li>
                            <li>Debito</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=nota_credito_debito" class="btn btn-light" title="Ver notas de credito y debito"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 6 orden de compra -->

            <!-- bloque 6 orden de compra -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Cuentas a pagar</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Cuentas a</li>
                            <li>Pagar</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=cuentas_a_pagar" class="btn btn-light" title="Ver cuentas a pagar"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 6 orden de compra -->
        </div>
    </section>
<?php } elseif ($_SESSION['permisos_acceso'] == 'Compras') { ?>
    <section class="content-header">
        <h1>
            <i class="cil-home icon-title"></i>Inicio
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    <p style="font-size: 15px;">
                        <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 1 compras -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Compras</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Compra</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=compras" class="btn btn-light" title="Registrar compras" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 1 compras -->

            <!-- bloque 3 stock -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Stock de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Stock</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->
        </div>
    </section>
<?php } elseif ($_SESSION['permisos_acceso'] == 'Ventas') { ?>
    <section class="content-header">
        <h1>
            <i class="cil-home icon-title"></i>Inicio
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    <p style="font-size: 15px;">
                        <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 2 ventas -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ventas</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Ventas</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=ventas" class="btn btn-light" title="Registrar ventas" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 2 ventas -->

            <!-- bloque 3 stock -->
            <div class="col-lg -4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Stock de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Stock</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->
        </div>
    </section>
<?php } ?>