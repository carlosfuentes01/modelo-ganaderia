<?php
include '../../conexion/conexion.php';

$sql = "SELECT * FROM inventario";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo " - Nombre: " . $row['nombre'] . " - Cantidad: " . $row['cantidad'] . "<br>";
    }
} else {
    echo "No hay inventario registrado.";
}
?>
