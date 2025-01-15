<?php
require_once "../../config/database.php";
if ($_GET['act'] == 'imprimir') {
    if (isset($_GET['cod_compra'])) {
        $codigo = $_GET['cod_compra'];
        //Cabecera de compra
        $cabecera_compra = mysqli_query($mysqli, "SELECT * FROM v_compras WHERE cod_compra = $codigo")
            or die('Error' . mysqli_error($mysqli));

        while ($data = mysqli_fetch_assoc($cabecera_compra)) {
            $cod = $data['cod_compra'];
            $orden = $data['id_orden'];
            $proveedor = $data['razon_social'];
            $deposito = $data['descrip'];
            $nro_factura = $data['nro_factura'];
            $nro_factura = $data['nro_factura'];
            // Aseguramos que el número tenga el formato '001-001-0000001'
            $nro_factura_formateado = sprintf('001-001-%07d', $nro_factura);
            $fecha = $data['fecha'];
            $hora = $data['hora'];
            $cantidad = $data['cantidad'];
            $precio = $data['precio'];
            $total = $precio * $cantidad;
            $usuario = $data['name_user'];
            $estado = $data['estado'];
        }
        //Detalle de compra
        $detalle_compra = mysqli_query($mysqli, "SELECT * FROM v_det_compra WHERE cod_compra=$codigo")
            or die("Error" . mysqli_error($mysqli));

    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura de compra</title>
</head>

<body>
    <div align="center">
        Registro de factura de compra <br>
        <label><strong>usuario:</strong><?php echo $usuario; ?></label><br>
        <label><strong>Proveedor:</strong><?php echo $proveedor; ?></label><br>
        <label><strong>Deposito:</strong><?php echo $deposito; ?></label><br>
        <label><strong>N° de Factura de compra:</strong><?php echo $nro_factura_formateado; ?></label><br>
        <label><strong>Fecha:</strong><?php echo $fecha; ?></label><br>
        <label><strong>Hora:</strong><?php echo $hora; ?></label><br>   
    </div>
    <hr>
    <div align="center">
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
            <thead style="background:#e8ecee">
                <tr class="tabla-title">
                    <th height="20" align="center" valign="middle"><small>Tipo de Producto</small></th>
                    <th height="20" align="center" valign="middle"><small>Producto</small></th>
                    <th height="20" align="center" valign="middle"><small>Unidad de Medida</small></th>
                    <th height="20" align="center" valign="middle"><small>Precio</small></th>
                    <th height="20" align="center" valign="middle"><small>Cantidad</small></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data2 = mysqli_fetch_assoc($detalle_compra)) {
                    $t_p_descrip = $data2['t_p_descrip'];
                    $p_descrip = $data2['p_descrip'];
                    $u_medida = $data2['u_descrip'];
                    $precio = $data2['precio'];
                    $cantidad = $data2['cantidad'];

                    echo "<tr>
                                  <td width='100' align='left'>$t_p_descrip</td>
                                  <td width='80' align='left'>$p_descrip</td>
                                  <td width='80' align='left'>$u_medida</td>
                                  <td width='80' align='left'>$precio</td>
                                  <td width='80' align='left'>$cantidad</td>
                                  </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div align="center">
        <label><strong>El total de la compra es: Gs.<?php echo number_format($total); ?></strong></label>
    </div>
</body>

</html>