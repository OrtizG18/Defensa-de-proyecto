<?php
session_start();
$session_id = session_id();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
    exit;
}

if ($_GET['act'] == 'insert') {
    if (isset($_POST['Guardar'])) {
        $mysqli -> begin_transaction();

        //recibir datos del formulario
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo'];
        $razon = $_POST['razon'];
        $fecha = $_POST['fecha'];

        $query_nota = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota WHERE v_compras.cod_compra = tmp_nota.cod_compra");
        $datos = mysqli_fetch_array($query_nota);
        $cod_prod = $datos['cod_producto'];
        $cod_depo = $datos['cod_deposito'];
        $precio = $datos['precio'];

        $cantidad_ajustar = $_POST['cant_cambio'] ?? 0;
        $estado = 'Pendiente';
        $user = $_SESSION['id_user'];

        // Obtener códigos
        $sql_c = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota WHERE v_compras.cod_compra = tmp_nota.cod_compra");
        $data_2 = mysqli_fetch_array($sql_c);
        $cod_compra = $data_2['cod_compra'];
        $cod_prove = $data_2['cod_proveedor'];

        //validar stock solo si el tipo es credito
        if($tipo === "credito"){
            $query_stock = $mysqli->prepare("SELECT cantidad FROM stock WHERE cod_producto = ? AND cod_deposito = ?");
            $query_stock -> bind_param("ii", $cod_prod, $cod_depo);
            $query_stock -> execute();
            $resultstock = $query_stock->get_result();
            $stockactual = $resultstock->fetch_assoc()['cantidad'];

            if($cantidad_ajustar > $stockactual){
                throw new exception("El monto a ajustar excede el stock disponible");
            }
        }

        $monto = ($cantidad_ajustar * $precio);

        //insertar detalle de nota
        $stmt = $mysqli->prepare("INSERT INTO det_nota (id_nota, cod_proveedor, cod_producto, cod_deposito, monto, razon, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("iiiiisi", $codigo, $cod_prove, $cod_prod, $cod_depo, $monto, $razon, $cantidad_ajustar);
        $stmt -> execute();

        //actualizar cuentas a pagar
        if ($tipo === "credito") {
            $stmt4 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total - ? WHERE cod_compra = ?");
        } elseif ($tipo === "debito") {
            $stmt4 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total + ? WHERE cod_compra = ?");
        }
        $stmt4->bind_param("di", $monto, $cod_compra);
        $stmt4->execute();

        //actualizar stock
        if ($tipo === "credito") {
            // Si es crédito, se debe restar el monto del stock
            $stmt4 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ?");
        } elseif ($tipo === "debito") {
            // Si es débito, se debe aumentar el monto al stock
            $stmt4 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ?");
        }
    
        $stmt4->bind_param('ii', $cantidad, $cod_prod);

        // Insertar cabecera de nota
        $stmt5 = $mysqli->prepare("INSERT INTO nota_credito_debito (id_nota, tipo, fecha_emision, estado, cod_compra, id_user) 
        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param("isssii", $codigo, $tipo, $fecha, $estado, $cod_compra, $user);
        $stmt5->execute();
        $stmt5->close();

        if ($stmt5) {
            header("Location: ../../main.php?module=nota_credito_debito&alert=4");
        } else {
            header("Location: ../../main.php?module=nota_credito_debito&alert=2");
        }
    }
} elseif ($_GET['act'] == 'anular') {
    if (isset($_GET['id_nota'])) {
        $codigo = $_GET['id_nota'];
        // Verificar si el estado no es 'rechazado'
        $result = mysqli_query($mysqli, "SELECT estado FROM nota_credito_debito WHERE id_nota = $codigo");
        $row = mysqli_fetch_assoc($result);

        if ($row['estado'] === 'anulado') {
            header("Location: ../../main.php?module=nota_credito_debito&alert=6");
        } else {

            $sql_f = mysqli_query($mysqli, "SELECT cod_compra FROM v_nota");
            echo $session_id;
            $data_3 = mysqli_fetch_array($sql_f);
            $cod_c = $data_3['cod_compra'];

            // Cambiar estado de la nota a 'anulado'
            $stmt7 = $mysqli->prepare("UPDATE nota_credito_debito SET estado = 'Anulado' WHERE id_nota = ?");
            $stmt7->bind_param("i", $codigo);
            $stmt7->execute();

            // Consultar detalles de la nota
            $stmt8 = $mysqli->prepare("SELECT monto, tipo FROM v_nota WHERE id_nota = ?");
            $stmt8->bind_param("i", $codigo);
            $stmt8->execute();
            $result2 = $stmt8->get_result();

            while ($row = $result2->fetch_assoc()) {
                $monto = $row['monto'];
                $tipo = $row['tipo'];

                // Ajustar el monto total dependiendo del tipo de nota
                if ($tipo === "credito") {
                    $stmt9 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total + ? WHERE cod_compra = ?");
                } elseif ($tipo === "debito") {
                    $stmt9 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total - ? WHERE cod_compra = ?");
                }
                $stmt9->bind_param("di", $monto, $cod_c);
                $stmt9->execute();
                $stmt9->close();
            }

            $stmt8->close();

            if ($stmt7) {
                header("Location: ../../main.php?module=nota_credito_debito&alert=1");
            } else {
                header("Location: ../../main.php?module=nota_credito_debito&alert=2");
            }
        }
    }
} elseif ($_GET['act'] == 'aprobar') {
    if (isset($_GET['id_nota'])) {
        $codigo = $_GET['id_nota'];
        // Verificar si el estado no es 'rechazado'
        $result = mysqli_query($mysqli, "SELECT estado FROM nota_credito_debito WHERE id_nota = $codigo");
        $row = mysqli_fetch_assoc($result);

        if ($row['estado'] === 'anulado') {
            header("Location: ../../main.php?module=nota_credito_debito&alert=5");
        } else {
            $query = mysqli_query($mysqli, "UPDATE nota_credito_debito SET estado = 'Aprobado' WHERE id_nota= $codigo")
                or die("Error: " . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=nota_credito_debito&alert=3");
            } else {
                header("Location: ../../main.php?module=nota_credito_debito&alert=2");
            }
        }
    }
}
?>