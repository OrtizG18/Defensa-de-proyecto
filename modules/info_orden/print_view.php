<?php
require_once "../../config/database.php";

$fecha_desde = $_GET['fecha_desde'] ?? null;
$fecha_hasta = $_GET['fecha_hasta'] ?? null;
$estado = $_GET['estado'] ?? null;

// Verificar si se han proporcionado las fechas
if (!$fecha_desde || !$fecha_hasta || !$estado) {
    echo "<script>alert('Debe aplicar un filtro primero (fecha desde y hasta y el estado).'); window.close(); window.location.href='http://localhost/proyecto_mt/main.php?module=info_orden';</script>";
    exit;
}

$query = mysqli_query($mysqli, "SELECT * FROM v_orden")
   or die('Error: ' . mysqli_error($mysqli));

$count = mysqli_num_rows($query);

// Extraer los datos para el encabezado
$header_data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Nota</title>
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
            text-align: left; /* Centrar contenido del contenedor */
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
            margin: 0 auto; /* Centrar la tabla */
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 3px;
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
        <h1>Informe de Ordenes de compra</h1>
        <div class="header-info" align="center">
            <p><strong>Usuario:</strong> <?php echo $header_data['name_user']; ?></p>
            <p><strong>Fecha Desde:</strong> <?php echo $fecha_desde; ?></p>
            <p><strong>Fecha Hasta:</strong> <?php echo $fecha_hasta; ?></p>
        </div>
        <div class="summary">
            <p><strong>Cantidad de Resultados:</strong> <?php echo $count; ?></p>
        </div>
        <hr>
        <div>
            <!-- Tabla centrada -->
            <table width="100%" align="center"> <!-- Uso de align="center" para compatibilidad -->
                <thead>
                    <tr>
                        <th height="20" align="center" valign="middle">ID Orden</th>
                        <th height="20" align="center" valign="middle">ID Presupuesto</th>
                        <th height="20" align="center" valign="middle">Fecha</th>
                        <th height="20" align="center" valign="middle">Hora</th>
                        <th height="20" align="center" valign="middle">Producto</th>
                        <th height="20" align="center" valign="middle">Cantidad Aprobada</th>
                        <th height="20" align="center" valign="middle">Precio Unitario</th>
                        <th height="20" align="center" valign="middle">Total</th>
                        <th height="20" align="center" valign="middle">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($query, 0); // Resetear el puntero de la consulta
                    if ($query) {
                        while ($data = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td class='text-center'>{$data['id_orden']}</td>
                                <td class='text-center'>{$data['id_presupuesto']}</td>
                                <td class='text-center'>{$data['fecha']}</td>
                                <td class='text-center'>{$data['hora']}</td>
                                <td class='text-center'>{$data['p_descrip']}</td>
                                <td class='text-center'>{$data['cant_aprob']}</td>
                                <td class='text-center'>{$data['precio_unit']}</td>";
                                $total = ($data['cant_aprob'] * $data['precio_unit']);
                                echo "
                                <td class='text-center'>{$total}</td>
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
