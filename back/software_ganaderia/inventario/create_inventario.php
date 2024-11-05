<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO inventario (nombre, cantidad) VALUES ('$nombre', '$cantidad')";
    if ($conexion->query($sql) === TRUE) {
        echo "Inventario agregado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="create_inventario.php">
    Nombre del Inventario: <input type="text" name="nombre" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    <input type="submit" value="Agregar Inventario">
</form>
