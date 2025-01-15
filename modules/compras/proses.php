<?php
session_start();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=3'>";
    exit;
}

// Validación del timbrado
$hoy = date('Y-m-d');
$sql_vencimiento = $mysqli->prepare("SELECT * FROM timbrado_compra WHERE fecha_fin = ?");
$sql_vencimiento->bind_param("s", $hoy);
$sql_vencimiento->execute();
$result_vencimiento = $sql_vencimiento->get_result();

if ($result_vencimiento->num_rows > 0) {
    echo "<script>alert('El timbrado ya ha vencido. Por favor, renueve el timbrado antes de continuar.'); window.history.back();</script>";
    exit;
}

if ($_GET['act'] == 'insert' && isset($_POST['Guardar'])) {
    $codigo = $_POST['codigo'];
    $codigo_deposito = $_POST['codigo_deposito'];
    $codigo_proveedor = $_POST['codigo_proveedor'];
    $cod_sex = $_POST['codigo_orden'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $nro_factura = $_POST['nro_factura'];
    $usuario = $_SESSION['id_user'];
    $timbrado = $_POST['codigo_tim'];
    $timbrado_num = $_POST['numero_timbrado'];

    // Validar datos requeridos
    /*if (empty($codigo) || empty($codigo_deposito) || empty($codigo_proveedor) || empty($fecha) || empty($nro_factura) || empty($codigo_tim)) {
        echo "<script>alert('Error: Faltan datos obligatorios.'); window.history.back();</script>";
        exit;
    }*/

    // Obtener productos y calcular el total
    $sql_si = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto = tmp.id_producto");
    $total = 0;
    while ($data = mysqli_fetch_array($sql_si)) {
        $codigo_producto = $data['cod_producto'];
        $cantidad = $data['cantidad_tmp'];
        $precio_unit = $data['precio_tmp'];
        $total += $cantidad * $precio_unit;



        // Insertar en `detalle_compra`
        $stmt = $mysqli->prepare("INSERT INTO detalle_compra (cod_producto, cod_compra, cod_deposito, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidi", $codigo_producto, $codigo, $codigo_deposito, $precio_unit, $cantidad);
        $stmt->execute();
        $stmt->close();

        // Actualizar stock
        $query = $mysqli->prepare("SELECT * FROM stock WHERE cod_producto = ? AND cod_deposito = ?");
        $query->bind_param("ii", $codigo_producto, $codigo_deposito);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows == 0) {
            // Insertar si no existe
            $stmt2 = $mysqli->prepare("INSERT INTO stock (cod_deposito, cod_producto, cantidad) VALUES (?, ?, ?)");
            $stmt2->bind_param("iii", $codigo_deposito, $codigo_producto, $cantidad);
            $stmt2->execute();
            $stmt2->close();
        } else {
            // Actualizar si ya existe
            $stmt3 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ? AND cod_deposito = ?");
            $stmt3->bind_param("iii", $cantidad, $codigo_producto, $codigo_deposito);
            $stmt3->execute();
            $stmt3->close();
        }
    }

    // Calcular saldo
    $monto_pagar = 0; // Ajusta según tu lógica
    $saldo = $total - $monto_pagar;

    // Insertar en `det_cuenta_a_pagar`
    $stmt4 = $mysqli->prepare("INSERT INTO det_cuentas (cod_cuenta, monto_total, monto_pagado) VALUES (?, ?, ?)");
    $stmt4->bind_param("idd", $codigo, $total, $monto_pagar);
    $stmt4->execute();
    $stmt4->close();

    // Insertar en `cuentas_a_pagar`
    $stmt5 = $mysqli->prepare("INSERT INTO cuentas_a_pagar (cod_cuenta, cod_compra, cod_proveedor, fecha_emision, fecha_vencimiento, estado) VALUES (?, ?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 90 DAY), 'pendiente')");
    $stmt5->bind_param("iii", $codigo, $codigo, $codigo_proveedor);
    $stmt5->execute();
    $stmt5->close();
    $estado = 'activo';

    // Actualizar en `timbrado`
    $stmt = $mysqli->prepare("UPDATE timbrado_compra SET numero_timbrado = ? WHERE id_timbrado  = ?");
    $stmt->bind_param("ii", $timbrado_num, $timbrado);
    $stmt->execute();
    $stmt->close();

    // Insertar cabecera de compra
    $query = mysqli_query($mysqli, "INSERT INTO compra (cod_compra, cod_proveedor, id_user, id_orden, id_timbrado, nro_factura, fecha, estado, hora)
        VALUES ($codigo, $codigo_proveedor, $usuario,  $cod_sex, $timbrado ,$nro_factura, '$fecha', '$estado', '$hora')")
        or die("Error" . mysqli_error($mysqli));

    if ($query) {
        header("Location: ../../main.php?module=compras&alert=1");
    } else {
        header("Location: ../../main.php?module=compras&alert=3");
    }

} elseif ($_GET['act'] == 'anular') {
    if (isset($_GET['cod_compra'])) {
        $codigo = $_GET['cod_compra'];

        // Anular cabecera de compra (cambiar estado a anulado)
        $stmt7 = $mysqli->prepare("UPDATE compra SET estado = 'anulado' WHERE cod_compra = ?");
        $stmt7->bind_param("i", $codigo);
        $stmt7->execute();
        $stmt7->close();

        // Consultar detalle de compra
        $stmt8 = $mysqli->prepare("SELECT * FROM detalle_compra WHERE cod_compra = ?");
        $stmt8->bind_param("i", $codigo);
        $stmt8->execute();
        $result2 = $stmt8->get_result();
        while ($row = $result2->fetch_assoc()) {
            $codigo_producto = $row['cod_producto'];
            $codigo_deposito = $row['cod_deposito'];
            $cantidad = $row['cantidad'];

            // Actualizar stock (restando la cantidad)
            $stmt9 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ? AND cod_deposito = ?");
            $stmt9->bind_param("iii", $cantidad, $codigo_producto, $codigo_deposito);
            $stmt9->execute();
            $stmt9->close();
        }

        if ($stmt7) {
            header("Location: ../../main.php?module=compras&alert=2");
        } else {
            header("Location: ../../main.php?module=compras&alert=3");
        }
    }
}
?>