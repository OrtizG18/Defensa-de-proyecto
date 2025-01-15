<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cuentas a pagar</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de Cuentas a pagar
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>Lista de cuentas a pagar</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">ID compra</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Fecha de emision</th>
                                <th class="text-center">Fecha de vencimiento</th>
                                <th class="text-center">Monto total</th>
                                <th class="text-center">Monto pagado</th>
                                <th class="text-center">Saldo pendiente</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_cuentas")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod = $data['cod_cuenta'];
                                $cod_compra = $data['cod_compra'];
                                $proveedor = $data['razon_social'];
                                $fecha_e = $data['fecha_emision'];
                                $fecha_v = $data['fecha_vencimiento'];
                                $monto_total = $data['monto_total'];
                                $monto_pagado = $data['monto_pagado'];
                                $saldo_pendiente = $monto_total - $monto_pagado;
                                $estado = $data['estado'];

                                echo "<tr>
                                    <td class='text-center'>$cod</td>
                                    <td class='text-center'>$cod_compra</td>
                                    <td class='text-center'>$proveedor</td>
                                    <td class='text-center'>$fecha_e</td>
                                    <td class='text-center'>$fecha_v</td>
                                    <td class='text-center'>$monto_total</td>
                                    <td class='text-center'>$monto_pagado</td>
                                    <td class='text-center'>$saldo_pendiente</td>
                                    <td class='text-center'>$estado</td>
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