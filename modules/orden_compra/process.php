<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $id_user = $_SESSION['id_user'];

            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];

            // Obtener productos de la tabla tmp
            $sql = mysqli_query($mysqli, "
            SELECT DISTINCT tmp.id_producto, tmp.cantidad_tmp, tmp.precio_tmp
            FROM tmp
            ");

            $validacion_correcta = true; // Bandera/variable para verificar cantidades

            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $cant_tmp = $row['cantidad_tmp'];
                $precio_tmp = $row['precio_tmp'];

                // Obtener cantidad presupuestada
                $query_presupuesto = mysqli_query($mysqli, "
                    SELECT cantidad 
                    FROM det_presu 
                    WHERE cod_producto = $codigo_producto
                ");

                $row_presupuesto = mysqli_fetch_array($query_presupuesto);
                $cantidad_presupuestada = $row_presupuesto['cantidad'];

                // Validar cantidad
                if ($cant_tmp != $cantidad_presupuestada) {
                    $validacion_correcta = false;
                    break; // Salir del bucle si hay discrepancia
                }
            }

            if (!$validacion_correcta) {
                // Redirigir con alerta si las cantidades no coinciden
                header("Location: ../../main.php?module=orden_compra&alert=5");
                exit;
            }

            // Si la validación es correcta, proceder con la inserción
            mysqli_data_seek($sql, 0); // Reiniciar el puntero del resultado para volver a recorrerlo

            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $cant_tmp = $row['cantidad_tmp'];
                $precio_tmp = $row['precio_tmp'];

                // Verificar si ya existe el registro antes de insertar
                $check_query = mysqli_query($mysqli, "
                    SELECT * FROM det_orden_comp 
                    WHERE id_orden = $codigo AND cod_producto = $codigo_producto
                ");

                if (mysqli_num_rows($check_query) == 0) {
                    $insert_detalle = mysqli_query($mysqli, "
                        INSERT INTO det_orden_comp (id_orden, cod_producto, cant_aprob, precio_unit) 
                        VALUES ($codigo, $codigo_producto, $cant_tmp, $precio_tmp)
                    ") or die('Error: ' . mysqli_error($mysqli));
                }
            }

            // Obtener datos del pedido desde tmp_orden
            $sql_p = mysqli_query($mysqli, "
            SELECT * FROM tmp_orden
            ");
            $data = mysqli_fetch_array($sql_p);

            $codigo_presu = $data['id_presupuesto'];
            $estado = 'pendiente';

            // Insertar cabecera de orden de compra
            $query = mysqli_query($mysqli, "
            INSERT INTO orden_compra (id_orden, id_presupuesto, id_user, fecha, hora, estado) 
            VALUES ($codigo, $codigo_presu, $id_user, '$fecha', '$hora', '$estado')
            ") or die("Error: " . mysqli_error($mysqli));

            // Redirigir según el resultado
            if ($query) {
                header("Location: ../../main.php?module=orden_compra&alert=1");
            } else {
                header("Location: ../../main.php?module=orden_compra&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_orden'])) {
            $codigo = $_GET['id_orden'];
            $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado = 'Rechazado' WHERE id_orden= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=orden_compra&alert=2");
            } else {
                header("Location: ../../main.php?module=orden_compra&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_orden'])) {
            $codigo = $_GET['id_orden'];
            $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado = 'Aprobado' WHERE id_orden= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=orden_compra&alert=4");
            } else {
                header("Location: ../../main.php?module=orden_compra&alert=3");
            }
        }
    }
}
?>
