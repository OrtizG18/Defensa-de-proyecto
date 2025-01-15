<section class="container-fluid">
    <div class="row mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?module=start"><i class="cil-home"></i> Inicio</a>
            </li>
            <li class="breadcrumb-item active">Control de inventario</li>
        </ol>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="display-6">
                <i class="cil-folder"></i> Control de inventario
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
                        <!--buscador mediante deposito-->
                        <div class="col-md-4">
                            <label for="cod_deposito" class="form-label">Depósito</label>
                            <select class="form-select" name="cod_deposito" id="cod_deposito" required>
                                <option value="" disabled selected>--Seleccione un depósito--</option>
                                <?php 
                                    $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY cod_deposito ASC") 
                                                or die("error".mysqli_error($mysqli));
                                    while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                        echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <!--buscador mediante producto-->
                        <div class="col-md-4">
                            <label for="cod_producto" class="form-label">Producto</label>
                            <select class="form-select" name="cod_producto" id="cod_producto">
                                <option value="" disabled selected>--Seleccione un producto--</option>
                                <?php 
                                    $query_prod = mysqli_query($mysqli, "SELECT cod_producto, p_descrip FROM producto ORDER BY cod_producto ASC") 
                                                 or die("error".mysqli_error($mysqli));
                                    while ($data_prod = mysqli_fetch_assoc($query_prod)) {
                                        echo "<option value=\"$data_prod[cod_producto]\">$data_prod[cod_producto] | $data_prod[p_descrip]</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="cil-magnifying-glass"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php 
                // Solo ejecutar consulta si el formulario fue enviado
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cod_deposito = $_POST['cod_deposito'] ?? 1;

                    // Capturar los valores de los filtros
                    $cod_deposito = !empty($_POST['cod_deposito']) ? $_POST['cod_deposito'] : null;
                    $cod_producto = !empty($_POST['cod_producto']) ? $_POST['cod_producto'] : null;

                    // Consulta para obtener la descripción del depósito seleccionado
                    $query_deposito = mysqli_query($mysqli, "SELECT descrip FROM deposito WHERE cod_deposito = $cod_deposito");
                    $deposito = "";
                    if ($data_deposito = mysqli_fetch_assoc($query_deposito)) {
                        $deposito = $data_deposito['descrip'];
                    }

                    // Construir la consulta con los filtros
                    $conditions = [];
                    if ($cod_deposito) {
                        $conditions[] = "cod_deposito = $cod_deposito";
                    }
                    if ($cod_producto) {
                        $conditions[] = "cod_producto = $cod_producto";
                    }
                    $where_clause = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";

                    // Consulta principal para obtener los productos según los filtros
                    $query = mysqli_query($mysqli, "SELECT * FROM v_stock $where_clause") or die('error'.mysqli_error($mysqli));
                }
            ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="h4">Lista de productos en Stock<?php echo isset($deposito) ? ": $deposito" : ""; ?></h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Depósito</th>
                                <th class="text-center">Tip. Producto</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Unid. Medida</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (isset($query)) {
                                    while($data = mysqli_fetch_assoc($query)){
                                        echo "<tr>
                                            <td class='text-center'>{$data['descrip']}</td>
                                            <td class='text-center'>{$data['t_p_descrip']}</td>
                                            <td class='text-center'>{$data['p_descrip']}</td>
                                            <td class='text-center'>{$data['u_descrip']}</td>
                                            <td class='text-center'>{$data['cantidad']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No hay productos en stock.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
