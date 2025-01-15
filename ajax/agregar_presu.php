<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_orden (id_presupuesto ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_orden WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th>Codigo</th>
            <th>Proveedor</th>
            <th>Fecha de inicio</th>
            <th>Fecha de vencimiento</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($mysqli, "SELECT * FROM v_presu, tmp_orden WHERE v_presu.id_presupuesto = tmp_orden.id_presupuesto and tmp_orden.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $id_presupuesto = $row['id_presupuesto'];
            $razon_social = $row['razon_social'];
            $fecha_inicio = $row['fecha_inicio'];
            $fecha_v = $row['fecha_venci'];
            $p_descrip = $row['p_descrip'];
            $cantidad = $row['cantidad'];
            $estado = $row['estado'];
            ?>
            <tr>
                <td><?php echo $id_presupuesto; ?></td>
                <td><?php echo $razon_social; ?></td>
                <td><?php echo $fecha_inicio; ?></td>
                <td><?php echo $fecha_v; ?></td>
                <td><?php echo $p_descrip; ?></td>
                <td><?php echo $cantidad; ?></td>
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