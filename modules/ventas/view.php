<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
        <li class="breadcrumb-item active"><a href="?module=ventas">Ventas</a></li>
    </ol>
    <br>
    <hr>
    <h1 class="h3">
        <i class="fa fa-folder icon-title"></i> Datos de ventas
        <a class="btn btn-primary float-end" href="?module=form_ventas&form=add" title="Agregar" data-bs-toggle="tooltip">
            <i class="fa fa-plus"></i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <?php 
                if(empty($_GET['alert'])){
                    echo "";
                }
                elseif($_GET['alert']==1){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check-circle'></i> Exitoso!!!</h4>
                    Datos registrados correctamente </div>";
                }

                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check-circle'></i> Exitoso!!!</h4>
                    Datos anulados correctamente </div>";
                }

                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check-circle'></i> Error!!!</h4>
                    No se pudo realizar la acción</div>";
                }

                elseif ($_GET['alert'] == 4) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check-circle'></i> Stock insuficiente!!!</h4>
                    No se puede realizar la venta</div>";
                }
                
                elseif ($_GET['alert'] == 5) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='icon fa fa-check-circle'></i> Stock insuficiente!!!</h4>
                    La venta supera la cantidad de stock, no se puede realizar la venta</div>";
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <h2>Lista de Ventas</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Deposito</th>
                                <th class="text-center">N° Factura</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nro = 1;
                                $query = mysqli_query($mysqli, "SELECT *FROM v_ventas WHERE estado='activo'") or die('error'.mysqli_error($mysqli));

                                while($data = mysqli_fetch_assoc($query)){
                                    $cod_venta = $data['cod_venta'];
                                    $cli_nombre = $data['cli_nombre'];
                                    $deposito = $data['descrip'];
                                    $nro_factura = $data['nro_factura'];
                                    // Aseguramos que el número tenga el formato '001-001-0000001'
                                    $nro_factura_formateado = sprintf('001-001-%07d', $nro_factura);
                                    $fecha = $data['fecha'];
                                    $hora = $data['hora'];
                                    $total = $data['total_venta'];

                                    echo "<tr>
                                    <td class='text-center'>$cod_venta</td>
                                    <td class='text-center'>$cli_nombre</td>
                                    <td class='text-center'>$deposito</td>
                                    <td class='text-center'>$nro_factura_formateado</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$hora</td>
                                    <td class='text-center'>$total</td>
                                    <td class='text-center' width='90'>
                                    <div>"; ?>
                                    <a data-coreui-toggle="tooltip" title="Anular compra" class="btn btn-danger btn-sm" href="modules/ventas/process.php?act=anular&cod_venta=<?php echo $data['cod_venta']; ?>" onclick="return confirm('¿Estás seguro/a de anular la factura nro <?php echo $nro_factura_formateado; ?>???')"><i class="cil-trash"></i></a>
                                    
                                    <a data-coreui-toggle="tooltip" title="Imprimir factura de compra" class="btn btn-warning btn-sm" href="modules/ventas/print.php?act=imprimir&cod_venta=<?php echo $data['cod_venta']; ?>" target="_blank"><i class="cil-print"></i></a>
                                    <?php echo "</div>
                                    </td>
                                    </tr>"; ?>
                                <?php } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
