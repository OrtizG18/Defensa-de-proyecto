<section class="container-fluid">
    <div class="row mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?module=start"><i class="cil-home"></i> Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Filtrar ordenes de compra</a>
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="display-12">
                <i class="cil-filter"></i> Filtrar Ordenes de Compra
            </h1>
            <hr>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class="row g-3">
                        <div class="col-md-4">
                            <label for="fecha_desde" class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" id="fecha_desde" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" id="fecha_hasta" required>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" name="estado" id="estado" required>
                                <option value="" disabled selected>--Seleccione un estado--</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="rechazado">Rechazado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="cil-magnifying-glass"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            // Capturar valores del formulario
            $fecha_desde = $_POST['fecha_desde'] ?? null;
            $fecha_hasta = $_POST['fecha_hasta'] ?? null;
            $estado = $_POST['estado'] ?? null;

            // Validar que todos los campos estén completos
            if ($fecha_desde && $fecha_hasta && $estado) {
                $query = mysqli_query($mysqli, "
                    SELECT * 
                    FROM v_orden
                    WHERE fecha BETWEEN '$fecha_desde' AND '$fecha_hasta'
                      AND estado = '$estado'
                ") or die('Error: ' . mysqli_error($mysqli));
            } else {
                $query = false;
            }
            ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="h4">Resultados</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID Orden</th>
                                <th class="text-center">ID presupuesto</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad Aprobada</th>
                                <th class="text-center">Precio unitario</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query) {
                                while ($data = mysqli_fetch_assoc($query)) {
                                    echo "<tr>
                                            <td class='text-center'>{$data['id_orden_comp']}</td>
                                            <td class='text-center'>{$data['id_presupuesto']}</td>
                                            <td class='text-center'>{$data['name_user']}</td>
                                            <td class='text-center'>{$data['fecha']}</td>
                                            <td class='text-center'>{$data['hora']}</td>
                                            <td class='text-center'>{$data['p_descrip']}</td>
                                            <td class='text-center'>{$data['cantidad_aprobada']}</td>
                                            <td class='text-center'>{$data['precio_unit']}</td>";
                                    $total = ($data['cantidad_aprobada'] * $data['precio_unit']);
                                    echo "
                                    <td class='text-center'>{$total}</td>
                                    <td class='text-center'>{$data['estado']}</td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='10' class='text-center'>No se encontraron resultados.</td>
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