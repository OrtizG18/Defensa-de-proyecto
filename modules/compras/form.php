<?php
if ($_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="?module=compras">Compras</a></li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <h1><i class="fa fa-edit icon-title"></i> Agregar Compras</h1>
            </div>
            <div class="card">
                <div class="card-header"><strong>Formulario de Compras</strong></div>
                <form action="modules/compras/proses.php?act=insert" method="POST" class="form-horizontal">
                    <div class="card-body">
                        <?php
                        // Generar código único
                        $query_id = mysqli_query($mysqli, "SELECT MAX(cod_compra) as id FROM compra")
                            or die("Error: " . mysqli_error($mysqli));
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1 ?? 1;
                        ?>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Código</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>"
                                    readonly>
                            </div>

                            <label class="col-md-2 col-form-label">N° de Timbrado</label>
                                <div class="col-md-4">
                                <?php
                                    // Consulta para obtener el número de timbrado y el rango_inicio más reciente
                                    $query_tim = mysqli_query($mysqli, "SELECT id_timbrado, numero_timbrado, rango_inicio FROM timbrado_compra ORDER BY id_timbrado DESC LIMIT 1")
                                    or die("Error: " . mysqli_error($mysqli));

                                    $dato_timbrado = mysqli_fetch_assoc($query_tim);

                                    // Manejo de casos cuando no hay registros en la tabla
                                    if ($dato_timbrado) {
                                        $codigo_tim = $dato_timbrado['id_timbrado']; // ID del timbrado actual
                                        $numero_timbrado = $dato_timbrado['numero_timbrado']; // Número de timbrado de la base de datos
                                        $rango_inicio = $dato_timbrado['rango_inicio'] + 1; // Incrementar el rango de inicio
                                    } else {
                                        $codigo_tim = null; // Si no hay registros, el ID puede quedar vacío o inicializarse
                                        $numero_timbrado = 1; // Número de timbrado inicial por defecto
                                        $rango_inicio = 1; // Rango de inicio inicial por defecto
                                    }
                                    ?>
                                    <!-- Campo oculto para almacenar el id_timbrado -->
                                    <input type="hidden" name="codigo_tim" value="<?php echo $codigo_tim; ?>">
                                    <!-- Campo oculto para almacenar el rango_inicio -->
                                    <input type="hidden" name="rango_inicio" value="<?php echo $rango_inicio; ?>">
                                    <!-- Campo visible con el número de timbrado de la base de datos -->
                                    <input type="text" class="form-control" name="numero_timbrado" value="<?php echo $numero_timbrado; ?>" readonly>
                                </div>
                            
                        </div>
                        <br>
                        <div class="form-group row">
                        <label class="col-md-2 col-form-label">Fecha</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="fecha" value="<?php echo date("Y-m-d"); ?>"
                                    readonly>
                            </div>
                            <label class="col-md-2 col-form-label">Hora</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="hora" value="<?php echo date("H:i:s"); ?>"
                                    readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                        <label class="col-md-2 col-form-label">N° de Factura</label>
                            <div class="col-md-4">
                                <?php
                                $query_id = mysqli_query($mysqli, "SELECT MAX(nro_factura) as nro FROM compra")
                                    or die("Error: " . mysqli_error($mysqli));
                                $data_id = mysqli_fetch_assoc($query_id);
                                $nro_factura = $data_id['nro'] + 1 ?? 1;

                                // Formatear el número de factura 
                                $formato_factura = "001-001-" . str_pad($nro_factura, 7, "0", STR_PAD_LEFT);
                                ?>

                                <!-- Campo para mostrar el formato de factura -->
                                <input type="text" class="form-control" value="<?php echo $formato_factura; ?>" readonly>

                                <!-- Campo oculto para enviar el número de factura real -->
                                <input type="hidden" name="nro_factura" value="<?php echo $nro_factura; ?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">

                        <label class="col-md-2 col-form-label">Orden de compra</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_orden" required>
                                    <option value="" disabled selected>-- Seleccionar Orden --</option>
                                    <?php
                                    $query_prove = mysqli_query($mysqli, "SELECT id_orden, p_descrip, estado FROM v_orden ORDER BY id_orden ASC")
                                        or die("Error: " . mysqli_error($mysqli));
                                    while ($row = mysqli_fetch_assoc($query_prove)) {
                                        echo "<option value='{$row['id_orden']}'>{$row['p_descrip']} || {$row['estado']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <label class="col-md-2 col-form-label">Proveedor</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_proveedor" required>
                                    <option value="" disabled selected>-- Seleccionar Proveedor --</option>
                                    <?php
                                    $query_prove = mysqli_query($mysqli, "SELECT cod_proveedor, razon_social FROM proveedor ORDER BY razon_social ASC")
                                        or die("Error: " . mysqli_error($mysqli));
                                    while ($row = mysqli_fetch_assoc($query_prove)) {
                                        echo "<option value='{$row['cod_proveedor']}'>{$row['razon_social']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Depósito</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_deposito" required>
                                    <option value="" disabled selected>-- Seleccionar Depósito --</option>
                                    <?php
                                    $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY descrip ASC")
                                        or die("Error: " . mysqli_error($mysqli));
                                    while ($row = mysqli_fetch_assoc($query_dep)) {
                                        echo "<option value='{$row['cod_deposito']}'>{$row['descrip']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Producto</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info" data-coreui-toggle="modal"
                                    data-coreui-target="#myModal">
                                    <i class="cil-plus"></i> Agregar Productos
                                </button>
                            </div>
                        </div>
                        <div id="resultados" class="mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                        <a href="?module=compras" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<script>
    $(document).ready(function () {
        load(1);
    });

    function load(page) {
        var x = $("#x").val();
        var parametros = { "action": "ajax", "page": page, "x": x };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido.php',
            data: parametros,
            beforeSend: function (objeto) {
                $('#loader').html('<img src="./images/ajax-loader.gif">Cargando....');
            },
            success: function (data) {
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader').html('');
            }
        });
    }

    function agregar(id) {
        var precio_compra = $('#precio_compra_' + id).val();
        var cantidad = $('#cantidad_' + id).val();
        if (isNaN(cantidad)) {
            alert('Esto no es un número');
            document.getElementById('cantidad_' + id).focus();
            return false;
        }
        if (isNaN(precio_compra)) {
            alert('Esto no es un número');
            document.getElementById('precio_compra_' + id).focus();
            return false;
        }
        // Fin de la validación
        var parametros = { "id": id, "precio_compra_": precio_compra, "cantidad": cantidad };
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_pedido.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }

    function eliminar(id) {
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_pedido.php",
            data: "id=" + id,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }
</script>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModallabel">Buscar Productos</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="x" placeholder="Buscar productos"
                                onkeyup="load(1)">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="load(1)">
                                <i class="cil-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>
                <div id="loader" class="text-center d-none">
                    <img src="./images/ajax-loader.gif" alt="Cargando..." /> Cargando...
                </div>
                <div class="outer_div"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
