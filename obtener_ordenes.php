<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Consulta SQL para obtener las órdenes (ajusta la consulta según tus necesidades)
$sql = "SELECT nro_op, fech_op, razon_social, importe_total, concepto FROM orn_ordenes";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Crear un array para almacenar los resultados
$ordenes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $ordenes[] = $row;
}

// Devolver los resultados como JSON
header('Content-Type: application/json');
echo json_encode($ordenes);

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
