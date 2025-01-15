<?php
require_once '../config/database.php';
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $x = mysqli_real_escape_string($mysqli, (strip_tags($_REQUEST['x'], ENT_QUOTES)));
    $aColumns = array('cod_producto', 'p_descrip');
    $sTable = "producto";
    $sWhere = ""; // Filtro por defecto para estado aprobado

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
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th style="width:36px;">Seleccion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($query)) {
                        $cod_producto = $row['cod_producto'];
                        $prod = $row['p_descrip']; ?>
                        <tr>
                            <td><?php echo $cod_producto; ?></td>
                            <td><?php echo $prod; ?></td> 
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control text-end" id="cantidad_<?php echo $cod_producto; ?>"
                                        value="1">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control text-end" id="precio_compra_<?php echo $cod_producto; ?>"
                                        value="0">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="agregarprod('<?php echo $cod_producto; ?>')">
                                    <i class="cil-plus"></i>
                                </button>
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