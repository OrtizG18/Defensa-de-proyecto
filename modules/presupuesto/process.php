<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];

            $fecha_e = $_POST['fecha_e']; // Fecha de emisión
            $fecha_v = $_POST['fecha_v']; // Fecha de vencimiento

            // Validar que la fecha de vencimiento no sea menor a la fecha de emisión
            if (strtotime($fecha_v) < strtotime($fecha_e)) {
                header("Location: ../../main.php?module=presupuesto&alert=5");
                exit;
            }

            // Obtener productos de la tabla tmp
            $sql = mysqli_query($mysqli, "
            SELECT DISTINCT tmp.id_producto, tmp.cantidad_tmp, tmp.precio_tmp
            FROM tmp
            ");

            while ($row = mysqli_fetch_array($sql)) {
            $codigo_producto = $row['id_producto'];
            $cant_tmp = $row['cantidad_tmp'];
            $precio_tmp = $row['precio_tmp'];

            // Verificar si ya existe el registro antes de insertar
            $check_query = mysqli_query($mysqli, "
                SELECT * FROM det_presu 
                WHERE id_presupuesto = $codigo AND cod_producto = $codigo_producto
            ");

            if (mysqli_num_rows($check_query) == 0) {
                $insert_detalle = mysqli_query($mysqli, "
                    INSERT INTO det_presu (id_presupuesto, cod_producto, cantidad, precio_unit) 
                    VALUES ($codigo, $codigo_producto, $cant_tmp, $precio_tmp)
                ") or die('Error: ' . mysqli_error($mysqli));
            }
            }

            // Obtener datos del pedido desde tmp_presu
            $sql_p = mysqli_query($mysqli, "
            SELECT * FROM tmp_presu
            ");
            $data = mysqli_fetch_array($sql_p);

            $codigo_pedido = $data['id_pedido'];
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $estado = 'pendiente';

            // Insertar cabecera de presupuesto
            $query = mysqli_query($mysqli, "
            INSERT INTO presupuesto (id_presupuesto, id_pedido, cod_proveedor, fecha_inicio, fecha_venci, estado) 
            VALUES ($codigo, $codigo_pedido, $codigo_proveedor, '$fecha_e', '$fecha_v', '$estado')
            ") or die("Error: " . mysqli_error($mysqli));

            // Redirigir según el resultado
            if ($query) {
            header("Location: ../../main.php?module=presupuesto&alert=1");
            } else {
            header("Location: ../../main.php?module=presupuesto&alert=3");
            }

        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_presupuesto'])) {
            $codigo = $_GET['id_presupuesto'];
            $query = mysqli_query($mysqli, "UPDATE presupuesto SET estado = 'Rechazado' WHERE id_presupuesto= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=presupuesto&alert=2");
            } else {
                header("Location: ../../main.php?module=presupuesto&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_presupuesto'])) {
            $codigo = $_GET['id_presupuesto'];
            $query = mysqli_query($mysqli, "UPDATE presupuesto SET estado = 'Aprobado' WHERE id_presupuesto= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=presupuesto&alert=4");
            } else {
                header("Location: ../../main.php?module=presupuesto&alert=3");
            }
        }
    }
}
?>
