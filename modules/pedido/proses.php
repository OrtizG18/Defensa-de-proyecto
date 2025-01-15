<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $codigo_deposito = $_POST['codigo_deposito'];
            //Insertar detalle de compra

            $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto = tmp.id_producto");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $precio = $row['precio_tmp'];
                $cantidad = $row['cantidad_tmp'];
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO det_pedido (id_pedido, cod_deposito, cod_producto, cantidad) 
                                                                       VALUES ($codigo, $codigo_deposito, $codigo_producto, $cantidad)") 
                                                                       or die('Error: ' . mysqli_error($mysqli));
            }
            //Insertar cabecera de compra 
            //Definir valores
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $estado = 'Pendiente';
            $usuario = $_SESSION['id_user'];
            //Insertar
            $query = mysqli_query($mysqli, "INSERT INTO pedido (id_pedido, id_user, fecha, hora, estado) 
                                                          VALUES ($codigo, $usuario, '$fecha', '$hora', '$estado')")
                                                          or die("Error" . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=pedido&alert=1");
            } else {
                header("Location: ../../main.php?module=pedido&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_pedido'])) {
            $codigo = $_GET['id_pedido'];
            //Anular cabecera de pedido (cambiar estado a rechazado)
            $query = mysqli_query($mysqli, "UPDATE pedido SET estado = 'No aprobado' WHERE id_pedido= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=pedido&alert=2");
            } else {
                header("Location: ../../main.php?module=pedido&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_pedido'])) {
            $codigo = $_GET['id_pedido'];
            //Anular cabecera de pedido (cambiar estado a rechazado)
            $query = mysqli_query($mysqli, "UPDATE pedido SET estado = 'Aprobado' WHERE id_pedido= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=pedido&alert=4");
            } else {
                header("Location: ../../main.php?module=pedido&alert=3");
            }
        }
    }
}

?>