<?php
if ($_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="?module=orden_compra">Ordenes de compra</a></li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <h1><i class="fa fa-edit icon-title"></i> Agregar ordenes de compra</h1>
            </div>
            <div class="card">
                <div class="card-header"><strong>Formulario de ordenes de compra</strong></div>
                <form action="modules/orden_compra/process.php?act=insert" method="POST" class="form-horizontal">
                    <div class="card-body">
                        <?php
                        // Generar código único
                        $query_id = mysqli_query($mysqli, "SELECT MAX(id_orden) as id FROM orden_compra")
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
                            <label class="col-md-2 col-form-label">Fecha</label>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <label class="col-md-2 col-form-label">Hora</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="hora" value="<?php echo date("H:i:s"); ?>"
                                    readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Presupuesto</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info" data-coreui-toggle="modal"
                                    data-coreui-target="#myModal">
                                    <i class="cil-plus"></i> Buscar Presupuesto
                                </button>
                            </div>
                            <div id="resultados" class="mt-3"></div>

                            <label class="col-md-2 col-form-label">Producto</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info" data-coreui-toggle="modal"
                                    data-coreui-target="#myModalprod">
                                    <i class="cil-plus"></i> Buscar Producto
                                </button>
                            </div>
                            
                        </div>
                        <div id="resulta2" class="mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                        <a href="?module=orden_compra" class="btn btn-secondary">Cancelar</a>
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
            url: './ajax/presupuestos.php',
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

    $(document).ready(function () {
        load2(1);
    });

    function load2(page) {
        var x = $("#x").val();
        var parametros = { "action": "ajax", "page": page, "x": x };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido_prod.php',
            data: parametros,
            beforeSend: function (objeto) {
                $('#loader_prod').html('<img src="./images/ajax-loader.gif">Cargando....');
            },
            success: function (data) {
                $(".outer_div2").html(data).fadeIn('slow');
                $('#loader_prod').html('');
            }
        });
    }

    function agregar(id) {
        // Fin de la validación
        var parametros = { "id": id};
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_presu.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }

    function agregarprod(id) {
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
        var parametros = { "id": id, "precio_compra_": precio_compra, "cantidad_": cantidad };
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_pedido_prod.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resulta2").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resulta2").html(datos);
            }
        });
    }

    function eliminar(id) {
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_presu.php",
            data: "id=" + id,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }

    function eliminar_prod(id) {
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_pedido_prod.php",
            data: "id=" + id,
            beforeSend: function (objeto) {
                $("#resulta2").html("Mensaje: cargando...");
            },
            success: function (datos) {
                $("#resulta2").html(datos);
            }
        });
    }

</script>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModallabel">Buscar Presupuesto</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="x" placeholder="Buscar pedido"
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
<br>
<div class="modal fade" id="myModalprod" tabindex="-1" aria-labelledby="myModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModallabelprod">Buscar Producto</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="x" placeholder="Buscar productos"
                                onkeyup="load2(1)">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="load2(1)">
                                <i class="cil-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>
                <div id="loader_prod" class="text-center d-none">
                    <img src="./images/ajax-loader.gif" alt="Cargando..." /> Cargando...
                </div>
                <div class="outer_div2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>