<?php
require_once "../../config/database.php";

$query = mysqli_query($mysqli, "SELECT * FROM departamento")
   or die('Error'.mysqli_error($mysqli));

   $count = mysqli_num_rows($query);
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de departamentos</title>
        <link rel="stylesheet" type="text/css" href="../../assets/img/campo.jpg">
    </head>
    <body>
        <div align="center">
            Reporte de ciudad
        </div>
        <div align="center">
             cantidad: <?php echo $count; ?>
        </div>
        <hr>
        <div>
            <table width="100%" border="0,3" cellpadding="0" cellspacing="0" align="center">
                <thead style="background:#e8ecee">
                    <tr class="table-title">
                        <th height="100" align="center" valing="middle"><small>Codigo</small></th>
                        <th height="100" align="center" valing="middle"><small>Descripcion</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                         while ($data = mysqli_fetch_assoc($query)){
                            $codigo = $data['id_departamento'];
                            $dep_descripcion = $data['dep_descripcion'];

                            echo "<tr>

                            <td width ='100' align='left'>$codigo</td>
                            <td width ='150' align='left'>$dep_descripcion</td>

                            </tr>";
                         }
                    ?>
                </tbody>
            </table>
        </div>
            
    </body>
</html>