<?php
require_once "../../config/database.php";

$fecha_desde = $_GET['fecha_desde'] ?? null;
$fecha_hasta = $_GET['fecha_hasta'] ?? null;
$estado = $_GET['estado'] ?? null;

// Verificar si se han proporcionado las fechas
if (!$fecha_desde || !$fecha_hasta || !$estado) {
    echo "<script>alert('Debe aplicar un filtro primero (fecha desde y hasta y el estado).'); window.close(); window.location.href='http://localhost/proyecto_mt/main.php?module=info_presu';</script>";
    exit;
}

$query = mysqli_query($mysqli, "SELECT * FROM v_presu ORDER BY id_presupuesto ASC")
   or die('Error: ' . mysqli_error($mysqli));

$count = mysqli_num_rows($query);

// Extraer los datos para el encabezado
$header_data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de presupuestos</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }
        h1 {
            font-size: 0.8rem;
            text-align: center;
            margin-bottom: 5px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.7rem;
        }
        .summary {
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            font-size: 0.5rem;
            margin: 0 auto;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }
        table thead {
            background-color: #007bff;
            color: black;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 0.4rem;
        }
    </style>
</head>
<body>
        <h1>Informe de Presupuestos</h1>
        <div class="header-info" align="center">
            <p><strong>Fecha Desde:</strong> <?php echo $fecha_desde; ?></p>
            <p><strong>Fecha Hasta:</strong> <?php echo $fecha_hasta; ?></p>
        </div>
        <div class="summary">
            <p><strong>Cantidad de Resultados:</strong> <?php echo $count; ?></p>
        </div>
        <hr>
        <div>
            <!-- Tabla centrada -->
            <table width="100%" align="center">
                <thead>
                    <tr>
                        <th height="20" align="center" valign="middle">ID Presupuesto</th>
                        <th height="20" align="center" valign="middle">Proveedor</th>
                        <th height="20" align="center" valign="middle">Fecha emitida</th>
                        <th height="20" align="center" valign="middle">Fecha de vencimiento</th>
                        <th height="20" align="center" valign="middle">Producto</th>
                        <th height="20" align="center" valign="middle">Cantidad</th>
                        <th height="20" align="center" valign="middle">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($query, 0); // Resetear el puntero de la consulta
                    if ($query) {
                        while ($data = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td class='text-center'>{$data['id_presupuesto']}</td>
                                <td class='text-center'>{$data['razon_social']}</td>
                                <td class='text-center'>{$data['fecha_inicio']}</td>
                                <td class='text-center'>{$data['fecha_venci']}</td>
                                <td class='text-center'>{$data['p_descrip']}</td>
                                <td class='text-center'>{$data['cantidad']}</td>
                                <td class='text-center'>{$data['estado']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='12'>No se encontraron resultados.</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Generado automáticamente el <?php echo date("d/m/Y H:i"); ?></p>
        </div>
</body>
</html>