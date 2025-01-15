<?php
require_once "../../config/database.php";

$query = mysqli_query($mysqli, "SELECT * FROM v_pedido WHERE estado = 'Aprobado'")
   or die('Error'.mysqli_error($mysqli));

   $count = mysqli_num_rows($query);
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de pedidos</title>
        <link rel="stylesheet" type="text/css" href="../../assets/img/campo.jpg">
    </head>
    <body>
        <div>
            Reporte de pedidos
        </div>
        <div align="center">
             cantidad: <?php echo $count; ?>
        </div>
        <hr>
        <div>
            <table width="100%" border="0,3" cellspacing="0" align="center">
                <thead style="background:#e8ecee">
                    <tr class="table-title">
                        <th height="20" align="center" valing="middle"><small>Codigo</small></th>
                        <th height="20" align="center" valing="middle"><small>Usuario</small></th>
                        <th height="20" align="center" valing="middle"><small>Fecha</small></th>
                        <th height="20" align="center" valing="middle"><small>Hora</small></th>
                        <th height="20" align="center" valing="middle"><small>Producto</small></th>
                        <th height="20" align="center" valing="middle"><small>Cantidad</small></th>
                        <th height="20" align="center" valing="middle"><small>Estado</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                         while ($data = mysqli_fetch_assoc($query)){
                            $codigo = $data['id_pedido'];
                            $name_user = $data['name_user'];
                            $fecha = $data['fecha'];
                            $hora = $data['hora'];
                            $p_descrip = $data['p_descrip'];
                            $cantidad = $data['cantidad'];
                            $estado = $data['estado'];

                            echo "<tr>

                            <td width ='80' align='left'>$codigo</td>
                            <td width ='200' align='left'>$name_user</td>
                            <td width ='200' align='left'>$fecha</td>
                            <td width ='200' align='left'>$hora</td>
                            <td width ='250' align='left'>$p_descrip</td>
                            <td width ='100' align='left'>$cantidad</td>
                            <td width ='200' align='left'>$estado</td>

                            </tr>";
                         }
                    ?>
                </tbody>
            </table>
        </div>
            
    </body>
</html>