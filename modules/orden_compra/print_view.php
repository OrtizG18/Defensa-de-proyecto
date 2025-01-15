<?php
require_once "../../config/database.php";
if ($_GET['act'] == 'imprimir') {
    if (isset($_GET['id_orden'])) {
        $codigo = $_GET['id_orden'];
        //Cabecera de compra
        $cabecera_orden = mysqli_query($mysqli, "SELECT * FROM orden_compra WHERE id_orden = $codigo")
            or die('Error' . mysqli_error($mysqli));

        while ($data = mysqli_fetch_assoc($cabecera_orden)) {
            $cod = $data['id_orden'];
            $fecha = $data['fecha'];
            $hora = $data['hora'];
        }
        //Detalle de compra
        $v_orden = mysqli_query($mysqli, "SELECT * FROM v_orden WHERE id_orden=$codigo")
            or die("Error" . mysqli_error($mysqli));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden de compra</title>
</head>

<body>
    <div align="center">
        Registro de Orden de compra<br>
        <label><strong>Fecha:</strong><?php echo $fecha; ?></label><br>
        <label><strong>Hora:</strong><?php echo $hora; ?></label><br>
    </div>
    <hr>
    <div align="center">
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
            <thead style="background:#e8ecee">
                <tr class="tabla-title">
                    <th height="20" align="center" valign="middle"><small>Usuario</small></th>
                    <th height="20" align="center" valign="middle"><small>Producto</small></th>
                    <th height="20" align="center" valign="middle"><small>Cantidad Aprobada</small></th>
                    <th height="20" align="center" valign="middle"><small>Precio Unitario</small></th>
                    <th height="20" align="center" valign="middle"><small>Estado</small></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data2 = mysqli_fetch_assoc($v_orden)) {
                    $name_user = $data2['name_user'];
                    $prod = $data2['p_descrip'];
                    $cant_aprob = $data2['cant_aprob'];
                    $precio_unit = $data2['precio_unit'];
                    $total = $cant_aprob * $precio_unit;
                    $estado = $data2['estado'];

                    echo "<tr>
                                  <td width='100' align='left'>$name_user</td>
                                  <td width='100' align='left'>$prod</td>
                                  <td width='80' align='left'>$cant_aprob</td>
                                  <td width='80' align='left'>$precio_unit</td>
                                  <td width='80' align='left'>$estado</td>
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