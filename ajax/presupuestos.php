<?php
require_once '../config/database.php';
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $x = mysqli_real_escape_string($mysqli, (strip_tags($_REQUEST['x'], ENT_QUOTES)));
    $aColumns = array('id_presupuesto', 'razon_social', 'fecha_inicio', 'fecha_venci', 'p_descrip', 'cantidad', 'estado');
    $sTable = "v_presu";
    $sWhere = "WHERE estado = 'aprobado' "; // Filtro por defecto para estado aprobado
    // Excluir presupuestos que ya existan en la tabla de orden compra
    $sWhere .= "AND id_presupuesto NOT IN (SELECT id_presupuesto FROM orden_compra) ";

    if (!empty($_GET['x'])) {
        $sWhere .= "AND ("; // Añadir búsqueda dinámica
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $x . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ")";
    }

    // Paginación
    include 'paginacion.php';
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    $count_query = mysqli_query($mysqli, "SELECT count(*) AS numeros FROM $sTable $sWhere");
    $row = mysqli_fetch_assoc($count_query);
    $numeros = $row['numeros'];
    $total_pages = ceil($numeros / $per_page);
    $reload = './index.php';

    $sql = "SELECT * FROM $sTable $sWhere LIMIT $offset, $per_page";
    $query = mysqli_query($mysqli, $sql);

    if ($numeros > 0) { ?>
        <div class="table-responsive">
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
                        <th style="width:36px;">Seleccion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($query)) {
                        $id_presupuesto = $row['id_presupuesto'];
                        $razon_social = $row['razon_social'];
                        $fecha_inicio = $row['fecha_inicio'];
                        $fecha_v = $row['fecha_venci'];
                        $prod = $row['p_descrip'];
                        $cantidad = $row['cantidad'];
                        $estado = $row['estado']; ?>
                        <tr>
                            <td><?php echo $id_presupuesto; ?></td>
                            <td><?php echo $razon_social; ?></td>
                            <td><?php echo $fecha_inicio; ?></td>
                            <td><?php echo $fecha_v; ?></td>
                            <td><?php echo $prod; ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td><?php echo $estado; ?></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="agregar('<?php echo $id_presupuesto; ?>')">
                                    <i class="cil-plus"></i>
                                </button>
                                <input type="hidden" name="id_pedido" value="<?php echo $id_presupuesto ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <nav aria-label="Page navigation">
                                <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                            </nav>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php }
}
?>