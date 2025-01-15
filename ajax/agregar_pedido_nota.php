<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_nota (cod_compra ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_nota WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>ID orden</th>
            <th>Nro. Fact</th>
            <th>Usuario</th>
            <th>Proveedor</th>
            <th>Deposito</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota WHERE v_compras.cod_compra = tmp_nota.cod_compra and tmp_nota.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $cod_compra = $row['cod_compra'];
            $id_orden = $row['id_orden'];
            $nro_fact = $row['nro_factura'];
            $name_user = $row['name_user'];
            $prov = $row['razon_social'];
            $deposito = $row['descrip'];
            $prod = $row['p_descrip'];
            $cantidad = $row['cantidad'];
            $precio = $row['precio'];
            $fecha = $row['fecha'];
            $hora = $row['hora'];
            $estado = $row['estado'];
            ?>
            <tr>
                <td><?php echo $cod_compra; ?></td>
                <td><?php echo $id_orden; ?></td>
                <td><?php echo $nro_fact; ?></td>
                <td><?php echo $name_user; ?></td>
                <td><?php echo $prov; ?></td>
                <td><?php echo $deposito; ?></td>
                <td><?php echo $prod; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td><?php echo $precio; ?></td>
                <td><?php echo $fecha; ?></td>
                <td><?php echo $hora; ?></td>
                <td><?php echo $estado; ?></td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" onclick="eliminar(<?php echo $id_tmp; ?>)">
                        <i class="cil-trash"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>