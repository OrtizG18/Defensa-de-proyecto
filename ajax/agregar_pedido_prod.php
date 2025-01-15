<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (isset($_POST['cantidad_'])) {
    $cantidad_ = $_POST['cantidad_'];
}
if (isset($_POST['precio_compra_'])) {
    $precio_compra_ = $_POST['precio_compra_'];
}

require_once '../config/database.php';

if (!empty($id) && !empty($cantidad_) && !empty($precio_compra_)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) VALUES ('$id', '$cantidad_', '$precio_compra_', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th>Codigo</th>
            <th>Producto</th>
            <th class="text-end">Cantidad</th>
            <th class="text-end">Precio Unitario</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $suma_to = 0;
        $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto = tmp.id_producto and tmp.session_id = '". $session_id ."'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $codigo_producto = $row['cod_producto'];
            $descrip_producto = $row['p_descrip'];
            $cantidad = $row['cantidad_tmp'];

            $precio_compra_ = $row['precio_tmp'];
            $precio_compra_f = number_format($precio_compra_);
            $precio_compra_r = str_replace(",", "", $precio_compra_f);
            $precio_total = $precio_compra_r * $cantidad;
            $precio_total_f = number_format($precio_total);
            $precio_total_r = str_replace(",", "", $precio_total_f);

            $suma_to += $precio_total_r;
            ?>
            <tr>
                <td><?php echo $codigo_producto; ?></td>
                <td><?php echo $descrip_producto; ?></td>
                <td class="text-end"><?php echo $cantidad; ?></td>
                <td class="text-end"><?php echo $precio_compra_; ?></td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" onclick="eliminar_prod(<?php echo $id_tmp; ?>)">
                        <i class="cil-trash"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <input type="hidden" class="form-control" name="suma_total" value="<?php echo $suma_to; ?>">
            <input type="hidden" class="form-control" name="codigo_producto"
                value="<?php echo $codigo_producto ?? 0; ?>">
            <input type="hidden" class="form-control" name="cantidad" value="<?php echo $cantidad ?? 0; ?>">
            <td colspan="5" class="text-end">Total Gs.</td>
            <td class="text-end"><strong><?php echo number_format($suma_to); ?></strong></td>
        </tr>
    </tfoot>
</table>