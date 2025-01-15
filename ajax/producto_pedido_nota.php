<?php
require_once '../config/database.php';
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $x = mysqli_real_escape_string($mysqli, (strip_tags($_REQUEST['x'], ENT_QUOTES)));
    $aColumns = array('cod_compra', 'id_orden', 'nro_factura', 'name_user', 'razon_social', 'descrip', 'p_descrip', 'cantidad', 'precio', 'fecha', 'hora', 'estado');
    $sTable = "v_compras";
    $sWhere = "WHERE estado = 'activo' "; // Filtro por defecto para estado aprobado
    // Excluir presupuestos que ya existan en la tabla de orden compra
    //$sWhere .= "AND cod_compra NOT IN (SELECT cod_compra FROM compra) ";

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
                        <th style="width:36px;">Seleccion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($query)) {
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
                        $estado = $row['estado']; ?>
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
                            <td>
                                <button class="btn btn-success btn-sm" onclick="agregar('<?php echo $cod_compra; ?>')">
                                    <i class="cil-plus"></i>
                                </button>
                                <input type="hidden" name="cod_compra" value="<?php echo $cod_compra ?>">
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