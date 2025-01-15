<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ordenes de compra</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de ordenes de compra
        <a class="btn btn-primary btn-sm float-end" href="?module=form_orden_compra&form=add" title="Agregar"
            data-coreui-toggle="tooltip">
            <i class="cil-plus"></i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($_GET['alert'])) {
                if ($_GET["alert"] == 1) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden de compra registrado correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 2) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden de compra rechazado correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 3) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-exclamation-circle'></i> Error!</h4>
                        No se pudo realizar la operación.
                    </div>";
                } elseif ($_GET["alert"] == 4) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden de compra aprobado.
                    </div>";
                }
                    elseif ($_GET["alert"] == 5) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                            <h4><i class='fa fa-check-circle'></i> Error!!</h4>
                            La cantidad ingresada es diferente a la cantidad del presupuesto
                        </div>";
                    }
                }
            ?>

            <div class="card">
                <div class="card-body">
                    <h2>Lista de orden de compra</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">ID presupuesto</th>
                                <th class="text-center">Productos</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Cantidad Aprobada</th>
                                <th class="text-center">Precio Unitario</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_orden WHERE estado = 'Pendiente' or estado = 'Aprobado' ORDER BY id_orden ASC")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $id_orden = $data['id_orden'];
                                $id_presu = $data['id_presupuesto'];
                                $p_descrip = $data['p_descrip'];
                                $user = $data['name_user'];
                                $fecha = $data['fecha'];
                                $hora = $data['hora'];
                                $cant_aprob = $data['cant_aprob'];
                                $precio = $data['precio_unit'];
                                $total = ($data['cant_aprob'] * $data['precio_unit']);
                                $estado = $data['estado'];

                                echo "<tr>
                                    <td class='text-center'>$id_orden</td>
                                    <td class='text-center'>$id_presu</td>
                                    <td class='text-center'>$p_descrip</td>
                                    <td class='text-center'>$user</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$hora</td>
                                    <td class='text-center'>$cant_aprob</td>
                                    <td class='text-center'>$precio</td>
                                    <td class='text-center'>$total</td>
                                    <td class='text-center'>$estado</td>
                                    <td class='text-center' width='80'>
                                        <div class='btn-group' role='group'>
                                            <a data-coreui-toggle='tooltip' title='Aprobar orden de compra' class='btn btn-success btn-sm'
                                                href='modules/orden_compra/process.php?act=aprobar&id_orden=$id_orden'
                                                onclick='return confirm(\"¿Estás seguro/a de aprobar el pedido $id_orden?\");'>
                                                <i class='cil-check'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Rechazar orden de compra' class='btn btn-danger btn-sm'
                                                href='modules/orden_compra/process.php?act=anular&id_orden=$id_orden'
                                                onclick='return confirm(\"¿Estás seguro/a de rechazar el orden de compra $id_orden?\");'>
                                                <i class='cil-x'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Imprimir orden de compra' class='btn btn-warning btn-sm'
                                                href='modules/orden_compra/print.php?act=imprimir&id_orden=$id_orden' target='_blank'>
                                                <i class='cil-print'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>