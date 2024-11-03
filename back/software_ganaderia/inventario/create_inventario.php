<?php
include 'conexion.php';

$usuario_dni = 1; // $_SESSION['dni'] //el uno es de prueba porque no tengo el incio de sesion 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO inventario (nombre, cantidad) VALUES ('$nombre', '$cantidad')";
    if ($conexion->query($sql) === TRUE) {
        echo "Nuevo inventario agregado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Nombre: <input type="text" name="nombre" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    <input type="submit" value="Agregar Inventario">
</form>
