<?php
session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $codigo_deposito = $_POST['cod_deposito'];
    
            // Verificar stock de cada producto antes de proceder
            $sql_verificar = mysqli_query($mysqli, "SELECT tmp.id_producto, tmp.cantidad_tmp, stock.cantidad AS stock_actual
                                        FROM tmp
                                        LEFT JOIN stock ON tmp.id_producto = stock.cod_producto
                                        AND stock.cod_deposito = $codigo_deposito")
                                        or die('Error en la consulta de stock: ' . mysqli_error($mysqli));

            $error_stock = false;
            $productos_sin_stock = [];
            $productos_excedidos = [];

            while ($row = mysqli_fetch_array($sql_verificar)) {
                $id_producto = $row['id_producto'];
                $cantidad_solicitada = $row['cantidad_tmp'];
                $stock_actual = $row['stock_actual'];

                // Verifica si no hay stock en el depósito
                if ($stock_actual === null) {
                    $error_stock = true;
                    $productos_sin_stock[] = $id_producto;
                }
                // Verifica si la cantidad solicitada excede el stock disponible
                elseif ($cantidad_solicitada > $stock_actual) {
                    $error_stock = true;
                    $productos_excedidos[] = $id_producto;
                }
            }

            // Si hay errores de stock, redirigir y detener el script
            if ($error_stock) {
                // Limpia la tabla temporal para los productos problemáticos
                $productos_a_limpiar = array_merge($productos_sin_stock, $productos_excedidos);
                $delete_tmp = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_producto IN (" . implode(',', $productos_a_limpiar) . ")")
                              or die('Error al limpiar la tabla temporal: ' . mysqli_error($mysqli));
            
                // Redirige al usuario con un mensaje detallado según el tipo de error
                if (!empty($productos_sin_stock)) {
                    header("Location: ../../main.php?module=ventas&alert=4");
                } elseif (!empty($productos_excedidos)) {
                    header("Location: ../../main.php?module=ventas&alert=5");
                }
                exit; // Detener ejecución tras la redirección
            }
    
            // Si no hay errores de stock, proceder con la inserción
            $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto = tmp.id_producto");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $precio = $row['precio_tmp'];
                $cantidad = $row['cantidad_tmp'];
        
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO det_venta (cod_producto, cod_venta, cod_deposito, det_precio_unit, det_cantidad)
                                                         VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)")
                                                         or die('Error al insertar detalle: ' . mysqli_error($mysqli));
        
                // Actualizar el stock
                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad - $cantidad
                                                           WHERE cod_producto = $codigo_producto
                                                           AND cod_deposito = $codigo_deposito")
                                                           or die('Error al actualizar stock: ' . mysqli_error($mysqli));
            }
        
            // Insertar datos en la tabla de ventas
            $codigo_cliente = $_POST['id_cliente'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $nro_factura = $_POST['nro_factura'];
            $suma_total = $_POST['suma_total'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];
        
            $query = mysqli_query($mysqli, "INSERT INTO venta (cod_venta, id_cliente, cod_deposito, nro_factura, fecha, hora, estado, total_venta, id_user)
                                            VALUES ($codigo, $codigo_cliente, $codigo_deposito, '$nro_factura', '$fecha', '$hora', '$estado', $suma_total, $usuario)")
                                            or die('Error al insertar venta: ' . mysqli_error($mysqli));
        
            if ($query) {
                header("Location: ../../main.php?module=ventas&alert=1");
            } else {
                header("Location: ../../main.php?module=ventas&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['cod_venta'])) {
            $codigo = $_GET['cod_venta'];
            // Anular cabecera de compra (cambiar a estado anulado)
            $query = mysqli_query($mysqli, "UPDATE venta SET estado='anulado' WHERE cod_venta=$codigo") 
                     or die('Error al anular la venta: ' . mysqli_error($mysqli));

            // Consultar detalle de compra con el código que llegó por el GET
            $sql = mysqli_query($mysqli, "SELECT * FROM det_venta WHERE cod_venta=$codigo");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['cod_producto'];
                $codigo_deposito = $row['cod_deposito'];
                $cantidad = $row['det_cantidad'];

                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad 
                                                            WHERE cod_producto = $codigo_producto
                                                            AND cod_deposito = $codigo_deposito") 
                                                            or die('Error al actualizar stock: ' . mysqli_error($mysqli));
            }
            if ($query) {
                header("Location: ../../main.php?module=ventas&alert=2");
            } else {
                header("Location: ../../main.php?module=ventas&alert=3");
            }
        }
    }
}
